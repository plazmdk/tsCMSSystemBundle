<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/13/14
 * Time: 9:37 PM
 */

namespace tsCMS\SystemBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Path extends Constraint {
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy() {
        return 'path.validator';
    }
} 