<?php

namespace LG\SaleBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate',      DateType::class)
            ->add('Type',ChoiceType::class, array(
                'choices' => array(
                    'Journée complète' => 'complete',
                    'Demi-journée (A partir de 14h00)' => 'half'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('contactMail',    EmailType::class)
            ->add('tickets', CollectionType::class, ["entry_type"=>TicketType::class, "allow_add"=>true, "by_reference"=>false])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LG\SaleBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lg_salebundle_booking';
    }


}
