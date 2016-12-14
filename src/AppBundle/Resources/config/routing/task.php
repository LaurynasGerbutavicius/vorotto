<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('task_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Task:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('task_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Task:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('task_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Task:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('task_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Task:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('task_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Task:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
