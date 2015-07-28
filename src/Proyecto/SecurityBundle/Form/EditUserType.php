<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditUserType
 *
 * @author Iliana
 */

namespace Proyecto\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditUserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, array(
                'required' => false,
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('password','repeated',array(
                'type' => 'password',
                'invalid_message' => 'Passwörter müssen übereinstimmen.',
                'first_name'      => 'pass',
                'second_name'     => 'confirm',
                'required' => false,
            ))
            ->add('name',null,array(
                'required' => false,
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('lastName',null,array(
                'required' => false,
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('email',null,array(
                'required' => false,
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('country',null,array(
                'required' => false,
                "attr" => array(
                    "class" => "form-control"
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\SecurityBundle\Entity\UserProject'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        //return 'proyecto_securitybundle_userproject_change_pass';
        return 'proyecto_securitybundle_userproject';
    }

}
