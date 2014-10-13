<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 7:23 PM
 */

namespace tsCMS\SystemBundle\Twig;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use tsCMS\SystemBundle\Model\RouteConfig;
use tsCMS\SystemBundle\Services\RouteService;
use tsCMS\SystemBundle\Services\SiteStructureService;

class SEOExtension extends \Twig_Extension {
    /** @var \tsCMS\SystemBundle\Services\RouteService  */
    private $routeService;
    /** @var \Symfony\Component\HttpFoundation\RequestStack  */
    private $requestStack;

    function __construct(RequestStack $requestStack, RouteService $routeService)
    {
        $this->requestStack = $requestStack;
        $this->routeService = $routeService;
    }

    public function getGlobals() {
        $route = $this->routeService->getRouteByDirectMatch($this->requestStack->getCurrentRequest()->getRequestUri());
        if (!$route) {
            return array();
        }
        return array(
            "title" => $route->getTitle(),
            "metatags" => $route->getMetatags(),
            "metadescription" => $route->getMetadescription()
        );
    }

    public function getName()
    {
        return 'seo_extension';
    }
} 