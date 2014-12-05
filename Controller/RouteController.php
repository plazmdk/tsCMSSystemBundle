<?php

namespace tsCMS\SystemBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
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

        $result = $routeService->getRoutes($query, $page, 15);
        $pages = null;

        if ($result instanceof Paginator) {
            $pages =  range(1,ceil($result->count()/15));
            $result = $result->getIterator();
        }

        return array(
            "result" => $result,
            "query" => $query,
            "page" => $page,
            "pages" => $pages
        );
    }

    /**
     * @Route("/routes/json", name="tscms_system_route_routeslist", options={"expose"=true})
     * @Secure("ROLE_ADMIN")
     */
    public function routeListAction() {
        /** @var RouteService $routeService */
        $routeService = $this->get("tsCMS.routeService");

        $searchResult = $routeService->getRoutes("", null);
        $result = array(
            array(
                "name" => "route.select",
                "url" => false
            )
        );

        foreach ($searchResult as $route) {
            $result[] = array(
                "name" => $route->getTitle(),
                "url" => "tsCMS://".$route->getName()
            );
        }

        return new JsonResponse($result);
    }
}
