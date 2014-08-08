<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/27/14
 * Time: 6:20 PM
 */

namespace tsCMS\SystemBundle\Model;


abstract class AbstractSiteStructureElement {
    public function getType() {
        $classNameParts = explode("\\",get_class($this));
        return end($classNameParts);
    }
} 