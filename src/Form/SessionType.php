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
                'label' => " ",
                'multiple' => true,
                'choices' => [
                    'Lundi' => 'MO',
                    'Mardi' => 'TU',
                    'Mercredi' => 'WE',
                    'Jeudi' => 'TH',
                    'Vendredi' => 'FR'
                ],
                'required' => false
            ])
            ->add('weekDays', ChoiceType::class, [
                'label' => " ",
                'multiple' => true,
                'choices' => [
                    'Lundi' => [
                        '1er' => '1MO',
                        '2ème' => '2MO',
                        '3ème' => '3MO',
                        '4ème' => '4MO'
                    ],
                    'Mardi' => [
                        '1er' => '1TU',
                        '2ème' => '2TU',
                        '3ème' => '3TU',
                        '4ème' => '4TU'
                    ],
                    'Mercredi' => [
                        '1er' => '1WE',
                        '2ème' => '2WE',
                        '3ème' => '3WE',
                        '4ème' => '4WE'
                    ],
                    'Jeudi' => [
                        '1er' => '1TH',
                        '2ème' => '2TH',
                        '3ème' => '3TH',
                        '4ème' => '4TH'
                    ],
                    'Vendredi' => [
                        '1er' => '1FR',
                        '2ème' => '2FR',
                        '3ème' => '3FR',
                        '4ème' => '4FR'
                    ]
                ],
                'required' => false
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
