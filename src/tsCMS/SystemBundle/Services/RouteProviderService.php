<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/23/14
 * Time: 6:55 PM
 */

namespace tsCMS\SystemBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProviderService implements RouteProviderInterface {
    /** @var RouteService */
    private $routeService;

    public function __construct(RouteService $routeService) {
        $this->routeService = $routeService;
    }

    /**
     * @return \tsCMS\SystemBundle\Services\RouteService
     */
    private function getRouteService()
    {
        return $this->routeService;
    }


    /**
     * Finds routes that may potentially match the request.
     *
     * This may return a mixed list of class instances, but all routes returned
     * must extend the core symfony route. The classes may also implement
     * RouteObjectInterface to link to a content document.
     *
     * This method may not throw an exception based on implementation specific
     * restrictions on the url. That case is considered a not found - returning
     * an empty array. Exceptions are only used to abort the whole request in
     * case something is seriously broken, like the storage backend being down.
     *
     * Note that implementations may not implement an optimal matching
     * algorithm, simply a reasonable first pass.  That allows for potentially
     * very large route sets to be filtered down to likely candidates, which
     * may then be filtered in memory more completely.
     *
     * @param Request $request A request against which to match.
     *
     * @return \Symfony\Component\Routing\RouteCollection with all Routes that
     *      could potentially match $request. Empty collection if nothing can
     *      match.
     */
    public function getRouteCollectionForRequest(Request $request)
    {
        $routeCollection = new RouteCollection();
        $routes = $this->getRouteService()->findPossibleRoutes($request->getPathInfo());
        foreach ($routes as $route) {
            $routeCollection->add($route->getName(), $this->convertRoute($route));
        }

        return $routeCollection;
    }

    /**
     * Find the route using the provided route name.
     *
     * @param string $name the route name to fetch
     * @param array $parameters DEPRECATED the parameters as they are passed
     *      to the UrlGeneratorInterface::generate call
     *
     * @return \Symfony\Component\Routing\Route
     *
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException if
     *      there is no route with that name in this repository
     */
    public function getRouteByName($name, $parameters = array())
    {
        $route = $this->getRouteService()->getRouteByName($name);

        if (!$route) {
            throw new RouteNotFoundException();
        }

        return $this->convertRoute($route);
    }

    /**
     * Find many routes by their names using the provided list of names.
     *
     * Note that this method may not throw an exception if some of the routes
     * are not found or are not actually Route instances. It will just return the
     * list of those Route instances it found.
     *
     * This method exists in order to allow performance optimizations. The
     * simple implementation could be to just repeatedly call
     * $this->getRouteByName() while catching and ignoring eventual exceptions.
     *
     * @param array $names the list of names to retrieve
     * @param array $parameters DEPRECATED the parameters as they are passed to
     *      the UrlGeneratorInterface::generate call. (Only one array, not one
     *      for each entry in $names.
     *
     * @return \Symfony\Component\Routing\Route[] iterable thing with the keys
     *      the names of the $names argument.
     */
    public function getRoutesByNames($names, $parameters = array())
    {
        $result = array();
        if (is_array($names)) {
            foreach ($names as $name) {
                try {
                    $result[] = $this->getRouteByName($name);
                } catch (\Exception $e) {}
            }
        }

        return $result;
    }

    /**
     * Convert tsCMS route to Symfony route
     *
     * @param \tsCMS\SystemBundle\Entity\Route $route
     * @return Route
     */
    private function convertRoute(\tsCMS\SystemBundle\Entity\Route $route) {
        $defaults = $route->getParameters();
        $defaults["_controller"] = $route->getController();

        $requirements = array();
        if ($route->getRequirements()) {
            $requirements = $route->getRequirements();
        }

        return new Route($route->getPath(), $defaults, $requirements);
    }
}