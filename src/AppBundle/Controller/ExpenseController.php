<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Controller\AppController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Expense controller.
 *
 */
class ExpenseController extends AppController
{
    protected $entityName = 'expense';
}
