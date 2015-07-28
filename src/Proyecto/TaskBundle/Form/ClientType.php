<?php

namespace Proyecto\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'attr' => array('class' => 'form-control'))
                )
//        ->add(
//        'name', 'bootstrap_collection', array(
//        'type' => 'text',
//        'allow_add' => true,
//        'prototype' => true,
//        'allow_delete' => true,
//        'add_button_text' => 'Add Client',
//        'delete_button_text' => 'Delete Client'
//        )
//        )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\TaskBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'proyecto_taskbundle_client';
    }

}
