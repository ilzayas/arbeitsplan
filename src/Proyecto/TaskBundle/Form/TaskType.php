<?php

namespace Proyecto\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('beginningDate', 'date', array('required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'))
                ->add('endingDate', 'date', array('required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'))
                ->add('notas', 'textarea', array(
                    'required' => false,
                    'attr' => array('rows' => 3)
                ))
                ->add('teil', 'textarea', array(
                    'required' => false,
                    'attr' => array('rows' => 3)
                ))
                ->add('erledig', 'checkbox', array(
                    'required' => false,))
                ->add('kontaktPerson', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('hpNummer', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('lieferant', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('beiLieferantAngefragt', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('ekPreis', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('angebotErstellt', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('angebotZuKunden', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('kundeBestellt', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('nichtMoglich', 'text', array(
                    'required' => false,
                    "attr" => array(
                        "class" => "form-control"
                    )
                ))
                ->add('client', 'entity', array(
                    "class" => 'TareaBundle:Client',
                    "attr" => array(
                        'placeholder' => 'Client',
                        'empty_value' => 'Choose an option',
                    ),
                    'empty_data' => null
                ))
                ->add('users', 'entity', array(
                    'required' => false,
                    "class" => 'ProyectoSecurityBundle:UserProject',
                    "attr" => array(
                        'empty_value' => 'Choose an option',
                    ),
                    'empty_data' => 'Choose an option',
                ))
                ->add('file', 'collection', array(
                    'allow_add' => true,
                    'options' => array('data_class' => 'Proyecto\TaskBundle\Entity\Document',
                        'required' => false,),
                    'prototype' => true,
                    'type' => 'file',
                    'allow_delete' => true,
                    'label' => 'File input',
                    ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\TaskBundle\Entity\Task'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'proyecto_taskbundle_task';
    }

}
