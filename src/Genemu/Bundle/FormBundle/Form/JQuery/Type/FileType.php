<?php

/*
 * This file is part of the GenemuFormBundle package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Form\JQuery\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Genemu\Bundle\FormBundle\Form\Core\EventListener\FileListener;
use Genemu\Bundle\FormBundle\Form\JQuery\DataTransformer\FileToValueTransformer;

/**
 * FileType
 *
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class FileType extends AbstractType
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * Constructs
     *
     * @param array  $options
     * @param string $rootDir
     */
    public function __construct(array $options, string $rootDir)
    {
        $this->options = $options;
        $this->rootDir = $rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $configs = $options['configs'];

        $builder
            ->addEventSubscriber(new FileListener($this->rootDir, $options['multiple']))
            ->addViewTransformer(new FileToValueTransformer($this->rootDir, $configs['folder'], $options['multiple']))
            ->setAttribute('rootDir', $this->rootDir)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_replace($view->vars, array(
            'entry_type' => HiddenType::class,
            'value' => $form->getViewData(),
            'multiple' => $options['multiple'],
            'configs' => $options['configs'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $configs = $this->options;

        $resolver
            ->setDefaults(array(
                'data_class' => null,
                'required' => false,
                'multiple' => false,
                'configs' => array(),
            ))
            ->setNormalizer('configs', function (Options $options, $value) use ($configs) {
                    if (!$options['multiple']) {
                        $value['multi'] = false;
                    }

                    return array_merge($configs, $value);
                }
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return \Symfony\Component\Form\Extension\Core\Type\FileType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'genemu_jqueryfile';
    }
}
