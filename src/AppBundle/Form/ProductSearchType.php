<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProductSearchEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('min', null, array(
                        'label' => 'Prix minimum :', 
                        'attr' => array('maxlength' => 7, 'class' => "col-6 col-md-2"),
                        'label_attr' => array('class' => 'col-6 col-md-2'),        
                    )
                )
                ->add('max', null, array(
                        'label' => 'Prix maximum :', 
                        'attr' => array('maxlength' => 7, 'class' => "col-6 col-md-2"),
                        'label_attr' => array('class' => 'col-6 col-md-2'), 
                    )
                )
                ->add('label', null, array(
                        'label' => 'Libellé :', 
                        'attr' => array('maxlength' => 60, 'class' => 'col-6 col-md-2'),
                        'label_attr' => array('class' => 'col-6 col-md-2'),
                    )
                )
                ->add('Filtrer', SubmitType::class, array(
                        'attr' => array('class' => 'col-6 col-md-4'), 
                    )
                );
    }
    
    public function getName() {
        return 'product_search';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductSearchEntity::class,
        ));
    }
    
}
