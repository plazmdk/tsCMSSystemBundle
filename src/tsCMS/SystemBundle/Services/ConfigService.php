<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 4/16/14
 * Time: 7:14 PM
 */

namespace tsCMS\SystemBundle\Services;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use tsCMS\SystemBundle\Entity\Config;
use tsCMS\SystemBundle\Event\UpdateRouteEvent;
use tsCMS\SystemBundle\tsCMSSystemEvents;

class ConfigService {
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    private $cache = null;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function set($name, $value) {
        $config = $this->getFromCacheOrLoadCache($name);
        if (!$config) {
            if ($value === null) {
                return;
            }
            $config = new Config();
            $config->setName($name);
            $this->entityManager->persist($config);
        }
        if ($value !== null) {
            $config->setValue($value);
        } else {
            $this->entityManager->remove($config);
        }

        $this->entityManager->flush();

    }

    public function get($name) {
        $config = $this->getFromCacheOrLoadCache($name);
        if ($config) {
            return $config->getValue();
        }
        return null;
    }

    /**
     * @param $name
     * @return Config
     */
    private function getFromCacheOrLoadCache($name) {
        if (!$this->cache) {
            $this->cache = $this->entityManager->createQuery("SELECT c FROM tsCMSSystemBundle:Config c INDEX BY c.name")->getResult();
        }

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        return null;
    }
} 