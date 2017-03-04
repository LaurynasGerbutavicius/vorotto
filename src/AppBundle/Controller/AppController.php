<?php
/**
 * Created by PhpStorm.
 * User: Laurynas
 * Date: 2017-02-25
 * Time: 10:47
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Expense;
use AppBundle\Entity\Income;
use AppBundle\Utils\Entity\EntityDataFormatter;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

abstract class AppController extends Controller
{
    protected $entityName;
    
    /**
     * @return Response
     */
    public function indexAction(Criteria $criteria = null, $filter = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entityFieldNames = $em->getClassMetadata($this->getEntityClass())
            ->getFieldNames();
        
        $entityFields = [];
        foreach ($entityFieldNames as $fieldName) {
            $entityFields[$fieldName] = $em->getClassMetadata($this->getEntityClass())
                ->getTypeOfField($fieldName);
        }

        if ($criteria) {
            $entities = $em->getRepository($this->getEntityClass())
                ->matching($criteria);
        } else {
            $entities = $em->getRepository($this->getEntityClass())
                ->findBy(['user' => $this->getUser()]);
        }
        
        return $this->render('default/list.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_fields' => $entityFields,
            'list' => $entities,
            'additional_data' => $this->getAdditionalListData($this->getUser()),
            'filter' => $filter
        ));
    }
    
    public function filterAction(Request $request) 
    {
        $from = $request->get('from');
        $to = $request->get('to');


        if ($from || $to) {
            $criteria = new Criteria();
            $dateFrom = new \DateTime($from);
            $dateTo = new \DateTime($to);
            if ($dateFrom instanceof \DateTime) {
                $criteria->where($criteria->expr()->gt("date", $dateFrom));
            }
            if ($dateTo instanceof \DateTime) {
                $criteria->andWhere($criteria->expr()->lt("date", $dateTo));
            }
            $criteria->andWhere($criteria->expr()->eq("user", $this->getUser()));

                
            $filter = ['from' => $from, 'to' => $to];

            $this->get('session')->getFlashBag()->add('info', 'message.filter_applied');
            
            return $this->indexAction($criteria, $filter);
        }

        return $this->indexAction();
    }
    
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass();
        $this->setEntityDefaults($entity);
        $form = $this->createForm($this->getEntityFormType(), $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->preEntitySave($entity, $form);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', 'message.record_saved');

            return $this->redirectToRoute($this->entityName . '_show', array('id' => $entity->getId()));
        }

        return $this->render('default/form.html.twig', array(
            'entity_name' => $this->entityName,
            'form' => $form->createView(),
            'form_type' => 'new'
        ));
    }

    /**
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->getEntityClass(), $id);
        $form = $this->createForm($this->getEntityFormType(), $entity, ['disabled' => true]);

        return $this->render('default/form.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_id' => $entity->getId(),
            'form' => $form->createView(),
            'form_type' => 'show'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->getEntityClass(), $id);
        $form = $this->createForm($this->getEntityFormType(), $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->preEntitySave($entity, $form);
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add('info', 'message.record_updated');

            return $this->redirectToRoute($this->entityName . '_edit', array('id' => $entity->getId()));
        }

        return $this->render('default/form.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_id' => $entity->getId(),
            'form' => $form->createView(),
            'form_type' => 'edit'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->getEntityClass(), $id);
        if ($entity) {
            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', 'message.record_deleted');
        }

        return $this->redirectToRoute($this->entityName . '_index');
    }
    
    protected function getAdditionalListData($user)
    {
        $em = $this->getDoctrine()->getManager();
        $totalIncome = $em->getRepository(Income::class)->getTotalIncome($user);
        $totalExpenses = $em->getRepository(Expense::class)->getTotalExpenses($user);

        return ['totals' => ['income' => $totalIncome, 'expense' => $totalExpenses]];
    }

    protected function setEntityDefaults($entity)
    {
        $entity->setUser($this->getUser());
        $entity->setQuantity(1);
    }

    protected function preEntitySave($entity, Form $form)
    {
        $formData = $form->getData();
        $entity->setAmount($formData->getPrice() * $formData->getQuantity());
    }

    /**
     * @return string
     */
    private function getEntityClass()
    {
        return EntityDataFormatter::getEntityClass($this->entityName);
    }

    /**
     * @return string
     */
    private function getEntityFormType()
    {
        return EntityDataFormatter::getEntityFormType($this->entityName);
    }
}