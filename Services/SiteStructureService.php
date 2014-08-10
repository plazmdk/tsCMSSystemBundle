<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 7:14 PM
 */

namespace tsCMS\SystemBundle\Services;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use tsCMS\SystemBundle\Event\BuildSiteStructureEvent;
use tsCMS\SystemBundle\tsCMSSystemEvents;

class SiteStructureService {
    /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface  */
    private $eventDispatcher;

    private $siteStructure = null;

    function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return \tsCMS\SystemBundle\Model\SiteStructureGroup[]
     */
    public function getSiteStructure() {
        if ($this->siteStructure === null) {
            $buildSiteStructureEvent = new BuildSiteStructureEvent();
            $this->getEventDispatcher()->dispatch(tsCMSSystemEvents::BUILD_SITE_STRUCTURE,$buildSiteStructureEvent);
            $this->siteStructure = $buildSiteStructureEvent->getElements();
        }
        return $this->siteStructure;
    }
} 