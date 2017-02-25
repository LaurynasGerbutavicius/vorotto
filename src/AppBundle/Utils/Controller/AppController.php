<?php
/**
 * Created by PhpStorm.
 * User: Laurynas
 * Date: 2017-02-25
 * Time: 10:47
 */

namespace AppBundle\Utils\Controller;

use AppBundle\Utils\Entity\EntityDataFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AppController extends Controller
{
    protected $entityName;
    
    /**
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entityFieldNames = $em->getClassMetadata($this->getEntityClass())
            ->getFieldNames();
        $entityFields = [];
        foreach ($entityFieldNames as $fieldName) {
            $entityFields[$fieldName] = $em->getClassMetadata($this->getEntityClass())
                ->getTypeOfField($fieldName);
        }

        $entities = $em->getRepository($this->getEntityClass())->findAll();

        return $this->render('default/list.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_fields' => $entityFields,
            'list' => $entities,
        ));
    }
    
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass();
        $form = $this->createForm($this->getEntityFormType(), $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

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
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('default/form.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_id' => $entity->getId(),
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm($this->getEntityFormType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute($this->entityName . '_edit', array('id' => $entity->getId()));
        }

        return $this->render('default/form.html.twig', array(
            'entity_name' => $this->entityName,
            'entity_id' => $entity->getId(),
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectToRoute($this->entityName . '_index');
    }

    /**
     * @param $entity
     * @return Form|FormInterface
     */
    private function createDeleteForm($entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($this->entityName . '_delete', array('id' => $entity->getId())))
            ->setMethod('DELETE')
            ->getForm();
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