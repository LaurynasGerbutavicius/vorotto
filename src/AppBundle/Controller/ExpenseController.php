<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Expense;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Expense controller.
 *
 */
class ExpenseController extends Controller
{
    /**
     * Lists all expense entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expenses = $em->getRepository('AppBundle:Expense')->findAll();

        return $this->render('expense/index.html.twig', array(
            'expenses' => $expenses,
        ));
    }

    /**
     * Creates a new expense entity.
     *
     */
    public function newAction(Request $request)
    {
        $expense = new Expense();
        $form = $this->createForm('AppBundle\Form\ExpenseType', $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expense);
            $em->flush($expense);

            return $this->redirectToRoute('expense_show', array('id' => $expense->getId()));
        }

        return $this->render('expense/new.html.twig', array(
            'expense' => $expense,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a expense entity.
     *
     */
    public function showAction(Expense $expense)
    {
        $deleteForm = $this->createDeleteForm($expense);

        return $this->render('expense/show.html.twig', array(
            'expense' => $expense,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing expense entity.
     *
     */
    public function editAction(Request $request, Expense $expense)
    {
        $deleteForm = $this->createDeleteForm($expense);
        $editForm = $this->createForm('AppBundle\Form\ExpenseType', $expense);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expense_edit', array('id' => $expense->getId()));
        }

        return $this->render('expense/edit.html.twig', array(
            'expense' => $expense,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a expense entity.
     *
     */
    public function deleteAction(Request $request, Expense $expense)
    {
        $form = $this->createDeleteForm($expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expense);
            $em->flush($expense);
        }

        return $this->redirectToRoute('expense_index');
    }

    /**
     * Creates a form to delete a expense entity.
     *
     * @param Expense $expense The expense entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Expense $expense)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expense_delete', array('id' => $expense->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
