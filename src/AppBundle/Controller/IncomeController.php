<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Expense;
use AppBundle\Entity\Income;
use AppBundle\Utils\Controller\AppController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Income controller.
 *
 */
class IncomeController extends AppController
{
    protected $entityName = 'income';

    /**
     * @param $user
     * @return array
     */
    public function getAdditionalListData($user)
    {
        $em = $this->getDoctrine()->getManager();
        $totalIncome = $em->getRepository(Income::class)->getTotalIncome($user);
        $totalExpenses = $em->getRepository(Expense::class)->getTotalExpenses($user);
        
        return ['totals' => ['income' => $totalIncome, 'expense' => $totalExpenses]];
    }
}
