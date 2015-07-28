<?php

namespace Proyecto\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HistoryType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action')
            ->add('beginningDate')
            ->add('endingDate')
            ->add('userProject')
            ->add('task')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Proyecto\TaskBundle\Entity\History'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'proyecto_taskbundle_history';
    }
}
