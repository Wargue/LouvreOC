<?php

namespace LG\SaleBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Time;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('visitDate',      DateType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'label' => 'Date de visite',
                'attr' => [
                    'class' => 'js-datepicker',
                    'data-provide' => 'datepicker',
                    'placeholder' => 'Cliquez ici pour choisir une date',
                ]

            ))
            ->add('Type',ChoiceType::class, array(
                'choices' => $this->dayChoice(),
                'expanded' => true,
                'multiple' => false,
                'label' => 'Type de réservation'
            ))
            ->add('contactMail',    EmailType::class, array(
                'label' => "Adresse mail de contact",
                'attr' => [
                    'placeholder' => 'Votre adresse mail'
                ]

            ))
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

    public function dayChoice(){

        $date = date('H');

        $day = ['Demi-journée (A partir de 14h00)' => 'Demi-journée'];

        if (14>$date){
            $day = ['Journée complète' => 'Journée complète', 'Demi-journée (A partir de 14h00)' => 'Demi-journée'];
        }

        return $day;
    }

}


