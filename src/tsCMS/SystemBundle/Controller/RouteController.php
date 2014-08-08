<?php

namespace tsCMS\SystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use tsCMS\SystemBundle\Services\RouteService;

class RouteController extends Controller
{
    /**
     * @Route("/select/route")
     * @Template("tsCMSMenuBundle:Menu:selectRoute.html.twig")
     */
    public function selectRouteAction(Request $request) {
        $query = $request->query->get("query");
        $page = $request->query->getInt("page", 1) - 1;

        /** @var RouteService $routeService */
        $routeService = $this->get("tsCMS.routeService");

        $search = $routeService->getRoutes($query, $page);
        return $search;
    }

    /**
     * @Route("/routes/json", name="tscms_system_route_routeslist", options={"expose"=true})
     * @Secure("ROLE_ADMIN")
     */
    public function routeListAction() {
        /** @var RouteService $routeService */
        $routeService = $this->get("tsCMS.routeService");

        $search = $routeService->getRoutes("", null);
        $result = array(
            array(
                "name" => "route.select",
                "url" => false
            )
        );

        foreach ($search['result'] as $route) {
            $result[] = array(
                "name" => $route->getTitle(),
                "url" => "tsCMS://".$route->getName()
            );
        }

        return new JsonResponse($result);
    }
}
