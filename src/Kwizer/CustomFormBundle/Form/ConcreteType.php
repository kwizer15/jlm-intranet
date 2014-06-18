<?php
namespace Kwizer\CustomFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Kwizer\CustomFormBundle\Entity\FieldList;
use Kwizer\CustomFormBundle\Form\FieldListType;

class ConcreteType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','integer')
			  //  ->add('type','entity',array('class'=>'Kwizer\CustomFormBundle\Entity\ConcreteType'))
		
		        ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event)
		        {
					$concrete = $event->getData();
					$form = $event->getForm();
				
					// vérifie si l'objet Product est "nouveau"
					// Si aucune donnée n'est passée au formulaire, la donnée est "null".
					// Ce doit être considéré comme un nouveau "Product"
					if ($concrete->getType())
					{
						$fields = $concrete->getType()->getFields();
						foreach ($fields as $field)
						$form->add($field->getTitle(), $field->getFieldType()->getFormTypeName(), $field->getOptions());
			   		}
		});
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'kwizer_customformbundle_concrete';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Kwizer\CustomFormBundle\Entity\Concrete',
				'empty_data' => function (FormInterface $form) {
					$datas = $form->get('others');
					return new Concrete($form->get('id')->getData(), $form->get('type')->getData());
				}
		));
	}
}