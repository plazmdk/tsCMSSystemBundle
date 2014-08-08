<?php
/**
 * Created by PhpStorm.
 * User: plazm
 * Date: 5/1/14
 * Time: 7:40 PM
 */

namespace tsCMS\SystemBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditorType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'editor'),
            'dirtyHTML' => false
        ));
    }
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['dirtyHTML']) {
            $view->vars['attr']['class'] .= " editor-dirty";
        }
    }

    public function getParent() {
        return 'textarea';
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'editor';
    }
}