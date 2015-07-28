<?php

namespace Proyecto\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProjectType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('password','repeated',array(
                'type' => 'password',
                'invalid_message' => 'Passwörter müssen übereinstimmen.',
                'first_name'      => 'pass',
                'second_name'     => 'confirm',
            ))
            ->add('name',null,array(
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('lastName',null,array(
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('email',null,array(
                "attr" => array(
                    "class" => "form-control"
                )
            ))
            ->add('country',null,array(
                "attr" => array(
                    "class" => "form-control"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\SecurityBundle\Entity\UserProject'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'proyecto_securitybundle_userproject';
    }
}
