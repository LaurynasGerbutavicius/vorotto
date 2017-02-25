<?php
/**
 * Created by PhpStorm.
 * User: Laurynas
 * Date: 2017-02-25
 * Time: 14:50
 */

namespace AppBundle\Utils\Entity;


class EntityDataFormatter
{
    /**
     * @param $entityName
     * @param string $bundleName
     * @param string $entityDir
     * @return string
     */
    public static function getEntityClass($entityName, $bundleName = 'AppBundle', $entityDir = 'Entity')
    {
        return $bundleName.'\\'.$entityDir.'\\'.EntityNameTransformer::transformEntityName($entityName);
    }

    /**
     * @param $entityName
     * @param string $bundleName
     * @param string $formTypeDir
     * @return string
     */
    public static function getEntityFormType($entityName, $bundleName = 'AppBundle', $formTypeDir = 'Form')
    {
        return $bundleName.'\\'.$formTypeDir.'\\'.EntityNameTransformer::transformEntityName($entityName).'Type';
    }
}