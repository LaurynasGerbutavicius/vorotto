<?php
/**
 * Created by PhpStorm.
 * User: Laurynas
 * Date: 2017-02-25
 * Time: 14:57
 */

namespace AppBundle\Utils\Entity;


class EntityNameTransformer
{
    /**
     * @param $entityName
     * @return mixed
     */
    public static function transformEntityName($entityName)
    {
        return str_replace(' ', '', ucfirst(str_replace('_', ' ', $entityName)));
    }
}