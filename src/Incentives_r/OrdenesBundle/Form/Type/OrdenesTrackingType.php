<?php

namespace Incentives\OrdenesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdenesTrackingType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad')
            ->add('tarjeta')
            ->add('ordenAmazon')
            ->add('cantidad')
            ->add('precio')
        ;

        $builder->add('tracking');
        $builder->add('Enviar', 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Incentives\OrdenesBundle\Entity\Tracking',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ordenestracking';
    }
}
