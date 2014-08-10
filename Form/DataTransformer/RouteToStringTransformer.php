<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/18/14
 * Time: 11:48 AM
 */

namespace tsCMS\SystemBundle\Form\DataTransformer;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use tsCMS\SystemBundle\Entity\Route;

class RouteToStringTransformer implements DataTransformerInterface {
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @param Route $value
     * @return mixed|string
     */
    public function transform($value)
    {
        if ($value === null) {
            return "";
        }

        return $value;
    }


    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        $object = $this->em->getRepository("tsCMSSystemBundle:Route")->find($value);

        if (!$object) {
            throw new TransformationFailedException(sprintf("Route with name %s not found", $value));
        }

        return $object;
    }
}