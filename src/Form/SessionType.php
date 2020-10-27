<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
