<?php

namespace ZHC\PhonebookBundle\Form;

use ZHC\PhonebookBundle\Entity\Number;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneNumber', TextType::class, [
                'label' => "Numéro de téléphone"
            ])
            ->add('name', TextType::class, [
                'label' => "Nom"
            ])
            ->add('type', ChoiceType::class, [
                'label' => "Type de numéro",
                'choices' => [
                    "Interne" => "internal",
                    "Externe" => "external"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Number::class
        ]);
    }
}
