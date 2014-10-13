<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 7:14 PM
 */

namespace tsCMS\SystemBundle\Services;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Proxy\Proxy;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use tsCMS\SystemBundle\Entity\Route;
use tsCMS\SystemBundle\Event\UpdateRouteEvent;
use tsCMS\SystemBundle\tsCMSSystemEvents;

class RouteService {
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }



    public function addRoute($name, $title, $path, $controller, $bundle, $parameters = array(), $requirements = array(), $dynamic = false, $override = false, $metatags = null, $metadescription = null) {
        $route = $this->getRouteByName($name);

        if ($route) {
            if (!$override) {
                throw new \Exception("RouteNameTaken");
            }
        }

        $directRoute = $this->getRouteByDirectMatch($path);
        if ($directRoute && (!$route || $route->getName() != $directRoute->getName())) {
            throw new \Exception("RouteExists");
        }

        $em = $this->entityManager;
        if (!$route) {
            $route = new Route($name, $path, $controller, $parameters, $requirements, $dynamic, $bundle, $title, $metatags, $metadescription);
            $em->persist($route);
        }

        $route->setPath($path);
        $route->setController($controller);
        $route->setParameters($parameters);
        $route->setRequirements($requirements);
        $route->setDynamic($dynamic);
        $route->setBundle($bundle);
        $route->setTitle($title);
        $route->setMetatags($metatags);
        $route->setMetadescription($metadescription);

        $em->flush();

        $updateEvent = new UpdateRouteEvent($name);
        $updateEvent->setPath($path);
        $updateEvent->setTitle($title);
        $this->eventDispatcher->dispatch(tsCMSSystemEvents::UPDATE_ROUTE, $updateEvent);
    }

    public function removeRoute($name, $dispatchEvent = true) {
        $route = $this->getRouteByName($name);
        if ($route) {
            $em = $this->entityManager;
            $em->remove($route);
            $em->flush();

            if ($dispatchEvent) {
                $updateEvent = new UpdateRouteEvent($name);
                $this->eventDispatcher->dispatch(tsCMSSystemEvents::UPDATE_ROUTE, $updateEvent);
            }
        }
    }

    /**
     * @param $path
     * @return Route[]
     */
    public function findPossibleRoutes($path) {
        $em = $this->entityManager;
        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata('tsCMSSystemBundle:Route', 'r');

        $sqlQuery = $em->createNativeQuery("
        SELECT r.* FROM route r WHERE r.path = ? AND r.dynamic = 0
        UNION
        SELECT r.* FROM route r WHERE r.path LIKE ? AND r.dynamic = 1
        ",$rsm);
        $sqlQuery->setParameter(1, $path);

        $pathParts = explode("/", $path,3);
        // If count is 2, search for /
        if (count($pathParts) == 2) {
            unset($pathParts[1]);
        }
        // If count is larger than 2, search for /(token1)
        if (isset($pathParts[2])) {
            unset($pathParts[2]);
        }

        $sqlQuery->setParameter(2, implode("/", $pathParts)."%");

        return $sqlQuery->getResult();
    }

    /**
     * @param $name
     * @return null|Route
     */
    public function getRouteByName($name) {
        return $this->entityManager->getRepository("tsCMSSystemBundle:Route")->find($name);
    }

    /**
     * @param $route
     * @return null|Route
     */
    public function getRouteByDirectMatch($route) {
        return $this->entityManager->getRepository("tsCMSSystemBundle:Route")->findOneBy(array("path" => $route));
    }

    /**
     * @param $entity
     * @return null|Route
     */
    public function getRouteByEntity($entity) {
        $name = $this->generateNameFromEntity($entity);

        return $this->getRouteByName($name);
    }

    /**
     * @param $entity
     * @return string
     * @throws \Exception
     */
    public function generateNameFromEntity($entity)
    {
        if (!method_exists($entity, "getId")) {
            throw new \Exception("Entity does not have id field");
        }
        $class = get_class($entity);
        $class = str_replace("Proxies\\__CG__\\","",$class);
        $id = $entity->getId();

        $name = $class . $id;
        return $name;
    }

    /**
     * @return mixed
     */
    public function getRoutes($query = null, $page = 0) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("r");
        $qb->from("tsCMSSystemBundle:Route","r");

        if ($query) {
            $qb->where("r.title LIKE :query");
            $qb->setParameter("query", $query);
        }

        if ($page !== null) {
            $qb->setMaxResults(15);
            $qb->setFirstResult($page * 15);

            $paginator = new Paginator($qb);
            return array(
                "page" => $page + 1,
                "pages" => range(1,ceil($paginator->count()/15)),
                "result" => $paginator->getIterator()
            );
        }

        return array(
            "result" => $qb->getQuery()->getResult()
        );
    }
} 