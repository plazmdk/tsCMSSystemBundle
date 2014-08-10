<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 4:41 PM
 */

namespace tsCMS\SystemBundle\Model;


class SiteStructureAction extends AbstractSiteStructureElement {
    private $title;
    private $action;

    function __construct($title, $action)
    {
        $this->title = $title;
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
} 