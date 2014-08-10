<?php
namespace tsCMS\SystemBundle\EventListener;



use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use tsCMS\SystemBundle\Interfaces\PathInterface;
use tsCMS\SystemBundle\Services\RouteService;

class PathEnabledEntityLoadListener {
    /** @var  ContainerInterface */
    protected $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if ($entity instanceof PathInterface) {
            /** @var RouteService $routeService */
            $routeService = $this->container->get("tsCMS.routeService");
            $route = $routeService->getRouteByEntity($entity);
            if ($route) {
                $entity->setPath($route->getPath());
            }

        }
    }
}