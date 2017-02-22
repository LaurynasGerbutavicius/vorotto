<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('expense_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Expense:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('expense_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Expense:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('expense_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Expense:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('expense_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Expense:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('expense_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Expense:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
