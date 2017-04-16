<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProductSearchEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('label')
                ->add('min')
                ->add('max')
                ->add('OK', SubmitType::class)
                ;
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
