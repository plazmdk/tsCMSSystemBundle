<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 10/13/14
 * Time: 7:17 PM
 */

namespace tsCMS\SystemBundle\Model;


use tsCMS\SystemBundle\Entity\Route;

class RouteConfig {
    private $path;
    private $metatags;
    private $metadescription;
    private $title;

    /**
     * @param mixed $metadescription
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;
    }

    /**
     * @return mixed
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }

    /**
     * @param mixed $metatags
     */
    public function setMetatags($metatags)
    {
        $this->metatags = $metatags;
    }

    /**
     * @return mixed
     */
    public function getMetatags()
    {
        return $this->metatags;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    public static function fromRoute(Route $route) {
        $routeConfig = new RouteConfig();
        $routeConfig->setTitle($route->getTitle());
        $routeConfig->setPath($route->getPath());
        $routeConfig->setMetatags($route->getMetatags());
        $routeConfig->setMetadescription($route->getMetadescription());
        return $routeConfig;
    }
}