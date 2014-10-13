<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/1/14
 * Time: 7:40 PM
 */

namespace tsCMS\SystemBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path','text',array(
            'attr' => array('class' => 'route'),
        ));
        $builder->add('title', 'text', array(
            'label' => 'routeConfig.title'
        ));
        $builder->add('metatags', 'text', array(
            'label' => 'routeConfig.metatags'
        ));
        $builder->add('metadescription', 'textarea', array(
            'label' => 'routeConfig.metadescription'
        ));
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'tsCMS\SystemBundle\Model\RouteConfig'
        ));
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