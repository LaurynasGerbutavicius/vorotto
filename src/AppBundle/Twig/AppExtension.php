<?php

// src/AppBundle/Twig/AppExtension.php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('entity_field', array($this, 'entityField')),
        );
    }

    /**
     *
     * Returns text or array.
     * Array must have "data" key.
     * Possible array keys: class, route, route_parameters.
     *
     * @param $data
     * @param $type
     * @param string $fieldName
     * @return array
     */
    public function entityField($data, $type, $fieldName = '')
    {
        switch ($type) {
            case 'date' :
                if ($data instanceof \DateTime) {
                    $weekDayNo = $data->format('w');
                    return ['data' => $data->format('Y-m-d'), 'chip_data' => 'weekday.'.$weekDayNo];
                } else {
                    return '';
                }
            case 'decimal' :
                $isCurrency = in_array($fieldName, ['price', 'amount']);
                return ['data' => $isCurrency ? $data : ($data + 0), 'class' => 'number', 'currency' => $isCurrency];
            default :
                return $data;
        }
    }

    public function getName()
    {
        return 'app_extension';
    }
}
///**
// * Created by PhpStorm.
// * User: Laurynas
// * Date: 2017-02-25
// * Time: 12:23
// */
//
//namespace AppBundle\Twig;
//
//
//class AppExtension extends \TwigExtension
//{
//    public function getFilters()
//    {
//        return array(
//            new \Twig_SimpleFilter('entity_field', array($this, 'entityField')),
//        );
//    }
//
//    /**
//     *
//     * Returns text or array.
//     * Array must have "data" key.
//     * Possible array keys: class, route, route_parameters.
//     *
//     * @param $data
//     * @param $type
//     * @param string $fieldName
//     * @return array
//     */
//    public function entityField($data, $type, $fieldName = '')
//    {
//        switch ($type) {
//            case 'date' :
//                if ($data instanceof \DateTime) {
//                    return $data->format('Y-m-d');
//                } else {
//                    return '';
//                }
//            case 'decimal' :
//                return ['data' => $data, 'class' => 'number'];
//            default :
//                return $data;
//        }
//    }
//
//    public function getName()
//    {
//        return 'app_extension';
//    }
//}