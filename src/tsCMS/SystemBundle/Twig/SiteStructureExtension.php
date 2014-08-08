<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 7:23 PM
 */

namespace tsCMS\SystemBundle\Twig;


use Symfony\Component\HttpFoundation\RequestStack;
use tsCMS\SystemBundle\Services\SiteStructureService;

class SiteStructureExtension extends \Twig_Extension {
    /** @var SiteStructureService */
    private $siteStructureService;
    /** @var \Symfony\Component\HttpFoundation\RequestStack */
    private $requestStack;

    private $adminPrefix;

    function __construct(SiteStructureService $siteStructureService, RequestStack $requestStack, $adminPrefix)
    {
        $this->siteStructureService = $siteStructureService;
        $this->requestStack = $requestStack;
        $this->adminPrefix = $adminPrefix;
    }

    public function getGlobals() {
        $request = $this->requestStack->getMasterRequest();
        if ($request && strpos($request->getPathInfo(),$this->adminPrefix) === 0) {
            return array(
                'siteStructure'    => $this->siteStructureService->getSiteStructure()
            );
        }
        return array();
    }

    public function getName()
    {
        return 'sitestructure_extension';
    }
} 