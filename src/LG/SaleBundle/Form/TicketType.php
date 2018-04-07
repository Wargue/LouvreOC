<?php

namespace LG\SaleBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Intl\Intl;


class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $countries = Intl::getRegionBundle()->getCountryNames();
        $builder
            ->add('nom',            TextType::class)
            ->add('prenom',         TextType::class)
            ->add('nationalite',    ChoiceType::class, array(
                'choices' => array_flip($countries),
                'label'=>'Pays'

            ))
            ->add('birthday',       BirthdayType::class)
            ->add('reduced',        CheckboxType::class, array('label' => 'Avez-vous droit à un tarif réduit?', 'required' => false))
            ->add('booking',        HiddenType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LG\SaleBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lg_salebundle_ticket';
    }


}
