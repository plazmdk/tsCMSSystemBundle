<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/13/14
 * Time: 9:39 PM
 */

namespace tsCMS\SystemBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use tsCMS\SystemBundle\Interfaces\PathInterface;
use tsCMS\SystemBundle\Services\RouteService;

class PathValidator extends ConstraintValidator {
    /** @var RouteService */
    private $routeService;

    public function __construct(RouteService $routeService) {
        $this->routeService = $routeService;
    }
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $object The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($object, Constraint $constraint)
    {

        if ($object instanceof PathInterface) {
            $route = $this->routeService->getRouteByDirectMatch($object->getRouteConfig()->getPath());

            if ($route) {
                $currentRoute = $this->routeService->getRouteByEntity($object);

                if (!$currentRoute) {
                    $this->context->addViolationAt("path","validation.path.new", array("%path%" => $object->getRouteConfig()->getPath()));
                } else if ($currentRoute->getPath() != $object->getRouteConfig()->getPath()) {
                    $this->context->addViolationAt("path","validation.path.existing", array("%path%" => $object->getRouteConfig()->getPath(), "%oldpath%" => $currentRoute->getPath()));
                }
            }
        }
    }
}