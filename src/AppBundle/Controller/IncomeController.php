<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Income;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Income controller.
 *
 */
class IncomeController extends Controller
{
    /**
     * Lists all income entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $incomes = $em->getRepository('AppBundle:Income')->findAll();

        return $this->render('income/index.html.twig', array(
            'incomes' => $incomes,
        ));
    }

    /**
     * Creates a new income entity.
     *
     */
    public function newAction(Request $request)
    {
        $income = new Income();
        $form = $this->createForm('AppBundle\Form\IncomeType', $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($income);
            $em->flush($income);

            return $this->redirectToRoute('income_show', array('id' => $income->getId()));
        }

        return $this->render('income/new.html.twig', array(
            'income' => $income,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a income entity.
     *
     */
    public function showAction(Income $income)
    {
        $deleteForm = $this->createDeleteForm($income);

        return $this->render('income/show.html.twig', array(
            'income' => $income,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing income entity.
     *
     */
    public function editAction(Request $request, Income $income)
    {
        $deleteForm = $this->createDeleteForm($income);
        $editForm = $this->createForm('AppBundle\Form\IncomeType', $income);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('income_edit', array('id' => $income->getId()));
        }

        return $this->render('income/edit.html.twig', array(
            'income' => $income,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a income entity.
     *
     */
    public function deleteAction(Request $request, Income $income)
    {
        $form = $this->createDeleteForm($income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($income);
            $em->flush($income);
        }

        return $this->redirectToRoute('income_index');
    }

    /**
     * Creates a form to delete a income entity.
     *
     * @param Income $income The income entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Income $income)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('income_delete', array('id' => $income->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
