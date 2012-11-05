<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       		->add('reference',null,array('label'=>'Référence','attr'=>array('class'=>'input-small')))
       		->add('barcode',null,array('label'=>'Code barre','required'=>false,'attr'=>array('class'=>'input-xlarge')))
            ->add('category',null,array('label'=>'Famille de produit'))
            ->add('designation',null,array('label'=>'Designation','attr'=>array('class'=>'input-xxlarge')))
            ->add('description',null,array('label'=>'Description longue','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
            ->add('supplier',null,array('label'=>'Fournisseur')) // Typeahead
            ->add('unity',null,array('label'=>'Unité','attr'=>array('class'=>'input-small')))
			->add('purchase','money',array('label'=>'Prix d\'achat HT','attr'=>array('class'=>'input-small')))
            ->add('discountSupplier','percent',array('type'=>'integer','label'=>'Remise fournisseur','attr'=>array('class'=>'input-mini'),'data'=>0))
            ->add('expenseRatio','percent',array('type'=>'integer','label'=>'Frais','attr'=>array('class'=>'input-mini'),'data'=>10))
            ->add('shipping','money',array('label'=>'Port','attr'=>array('class'=>'input-mini'),'data'=>0))
            ->add('margin','percent',array('type'=>'integer','label'=>'Coef.','attr'=>array('class'=>'input-mini'),'data'=>40))
            
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_producttype';
    }
}
