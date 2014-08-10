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

class AddonType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['prefixIcon'] = $options['prefixIcon'];
        $view->vars['prefixAction'] = $options['prefixAction'];

        $view->vars['postfixIcon'] = $options['postfixIcon'];
        $view->vars['postfixAction'] = $options['postfixAction'];

        $view->vars['hiddenInput'] = $options['hiddenInput'];


        if (is_object($view->vars['value'])) {
            $entity = $view->vars['value'];
            $previewValue = $options['previewValue'];
            if (preg_match_all("#e\.([a-z]+)#", $previewValue, $matches)) {
                foreach ($matches[1] as $match) {
                    $previewValue = str_replace("e.".$match,call_user_func(array($entity, "get".$match)),$previewValue);
                }
            }
            $entityValue = call_user_func(array($entity, "get".$options['entityValue']));
            $view->vars['previewValue'] = $previewValue;
            $view->vars['value'] = $entityValue;
        } else if ($view->vars['value'] && $options['previewValue']) {
            $view->vars['previewValue'] = $options['previewValue'];
        } else {
            $view->vars['previewValue'] = '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'prefixIcon' => null,
            'prefixAction' => null,
            'postfixIcon' => null,
            'postfixAction' => null,
            'hiddenInput' => false,
            'previewValue' => '',
            'entityValue' => 'id'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'addon';
    }
}