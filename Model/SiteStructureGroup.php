<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 4:35 PM
 */

namespace tsCMS\SystemBundle\Model;


class SiteStructureGroup {
    /** @var mixed */
    private $title;
    /** @var mixed */
    private $icon;
    /** @var AbstractSiteStructureElement[] */
    private $elements = array();

    function __construct($title, $icon)
    {
        $this->title = $title;
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return \tsCMS\SystemBundle\Model\AbstractSiteStructureElement[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function addElement(AbstractSiteStructureElement $element) {
        $this->elements[] = $element;
    }
} 