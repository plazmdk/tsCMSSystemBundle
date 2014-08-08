<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 4:41 PM
 */

namespace tsCMS\SystemBundle\Model;


class SiteStructureTree extends AbstractSiteStructureElement {
    private $id;
    private $title;

    private $action = null;
    private $contextmenu = array();
    private $subtree = array();

    private $sortCallback;

    function __construct($id,$title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param SiteStructureTree $subtree
     */
    public function addSubtreeElement($element)
    {
        $this->subtree[] = $element;
    }

    /**
     * @return SiteStructureTree[]
     */
    public function getSubtree()
    {
        return $this->subtree;
    }

    /**
     * @param SiteStructureAction $subtree
     */
    public function addContextmenuAction($action)
    {
        $this->contextmenu[] = $action;
    }

    /**
     * @return SiteStructureAction[]
     */
    public function getContextmenu()
    {
        return $this->contextmenu;
    }

    /**
     * @param mixed $sortCallback
     */
    public function setSortCallback($sortCallback)
    {
        $this->sortCallback = $sortCallback;
    }

    /**
     * @return mixed
     */
    public function getSortCallback()
    {
        return $this->sortCallback;
    }

    /**
     * @param SiteStructureAction $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return SiteStructureAction
     */
    public function getAction()
    {
        return $this->action;
    }

} 