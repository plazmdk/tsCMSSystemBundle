<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/1/14
 * Time: 7:40 PM
 */

namespace tsCMS\SystemBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'route'),
        ));
    }

    public function getParent() {
        return 'text';
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'route';
    }
}