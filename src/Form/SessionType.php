<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de la session"
            ])
            ->add('startAt', DateTimeType::class, [
                'label' => "Date et heure de début de session",
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => "Date et heure de fin de session",
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('registrationStartAt', DateType::class, [
                'label' => "Date de début d'inscription",
                'widget' => 'single_text',
            ])
            ->add('registrationEndAt', DateType::class, [
                'label' => "Date de fin d'inscription",
                'widget' => 'single_text',
            ])
            ->add('location', TextType::class, [
                'label' => "Adresse"
            ])
            ->add('maxRegistration', IntegerType::class, [
                'label' => "Nombre de places"
            ])
            ->add('frequency', ChoiceType::class, [
                'label' => "Fréquence",
                'choices' => [
                    'Hebdomadaire' => 'WEEKLY',
                    'Mensuel' => 'MONTHLY'
                ],
                'empty_data' => '',
                'required' => false,
                'attr' => [
                    'class' => 'recurrency_input'
                ]
            ])
            ->add('frequencyInterval', IntegerType::class, [
                'label' => 'Interval',
                'required' => false,
                'attr' => [
                    'class' => 'recurrency_input'
                ]
            ])
            ->add('days', ChoiceType::class, [
                'label' => "Jours",
                'multiple' => true,
                'choices' => [
                    'Lundi' => 'MO',
                    'Mardi' => 'TU',
                    'Mercredi' => 'WE',
                    'Jeudi' => 'TH',
                    'Vendredi' => 'FR'
                ],
                'required' => false,
                'attr' => [
                    'class' => 'recurrency_input'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
