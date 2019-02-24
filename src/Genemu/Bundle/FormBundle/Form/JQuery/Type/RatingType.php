<?php

namespace Genemu\Bundle\FormBundle\Form\JQuery\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setAttribute('configs', $options['configs']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $form->getConfig()->getAttribute('configs');
        if (!isset($view->vars['configs']['required'])) {
            $view->vars['configs']['required'] = $options['required'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'number' => 5,
            'configs' => array(),
            'expanded' => true,
            'choices' => function (Options $options) {
                $choices = array();
                for ($i=1; $i<=$options['number']; $i++) {
                    $choices[$i] = null;
                }
                return array_flip($choices);
            },
            'choices_as_values' => true,
        ));

        $resolver->setNormalizer('expanded', function (Options $options, $value) {
                return true;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'genemu_jqueryrating';
    }
}
