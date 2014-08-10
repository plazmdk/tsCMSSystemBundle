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

class BuildSiteStructureEvent extends Event {
    private $elements = array();

    /**
     * @return SiteStructureGroup[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function addElement(SiteStructureGroup $element) {
        $this->elements[] = $element;
    }

    public function addElements($elements) {
        if (!is_array($elements)) {
            throw new \InvalidArgumentException("Argument is not an array");
        }
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }
} 