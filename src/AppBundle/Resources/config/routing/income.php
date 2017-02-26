<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('income_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Income:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('income_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Income:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('income_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Income:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('income_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Income:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('income_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Income:delete'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

return $collection;
