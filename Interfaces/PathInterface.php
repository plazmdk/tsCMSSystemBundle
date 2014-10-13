<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/13/14
 * Time: 10:02 PM
 */

namespace tsCMS\SystemBundle\Interfaces;


use tsCMS\SystemBundle\Model\RouteConfig;

interface PathInterface {
    /**
     * @return RouteConfig
     */
    function getRouteConfig();
    function setRouteConfig($routeConfig);
} 