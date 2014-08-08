<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/25/14
 * Time: 7:40 PM
 */

namespace tsCMS\SystemBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="route")
 */
class Route {
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="string")
     */
    protected $path;
    /**
     * @ORM\Column(type="string")
     */
    protected $controller;
    /**
     * @ORM\Column(type="json_array")
     */
    protected $parameters;
    /**
     * @ORM\Column(type="json_array")
     */
    protected $requirements;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $dynamic;
    /**
     * @ORM\Column(type="string")
     */
    protected $bundle;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;


    function __construct($name, $path, $controller, $parameters, $requirements, $dynamic, $bundle, $title)
    {
        $this->controller = $controller;
        $this->dynamic = $dynamic;
        $this->name = $name;
        $this->parameters = $parameters;
        $this->path = $path;
        $this->requirements = $requirements;
        $this->bundle = $bundle;
        $this->title = $title;
    }

    /**
     * @param mixed $bundle
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * @return mixed
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $dynamic
     */
    public function setDynamic($dynamic)
    {
        $this->dynamic = $dynamic;
    }

    /**
     * @return mixed
     */
    public function getDynamic()
    {
        return $this->dynamic;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
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
     * @param mixed $requirements
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
    }

    /**
     * @return mixed
     */
    public function getRequirements()
    {
        return $this->requirements;
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

} 