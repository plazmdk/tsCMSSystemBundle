<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 4:05 PM
 */

namespace tsCMS\SystemBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use tsCMS\SystemBundle\Model\SiteStructureGroup;

class UpdateRouteEvent extends Event {
    private $route;
    private $path = null;
    private $title = null;

    function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
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
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }
} 