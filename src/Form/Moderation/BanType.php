<?php

namespace App\Form\Moderation;

use App\Entity\Moderation\Ban;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class BanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid', TextType::class, [
                'label' => 'Uuid du joueur',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: af860b2e418411ec81d30242ac130003',
                    'autofocus' => true
                ]
            ])
            ->add('banIp', TextType::class, [
                'label' => 'Ip du joueur',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 95.165.32.158'
                ]
            ])
            ->add('banReason', TextType::class, [
                'label' => 'Raison du ban',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Cheat (Xray)'
                ]
            ])
            ->add('banServer', TextType::class, [
                'label' => 'Nom du serveur',
                'attr' => [
                    'placeholder' => 'Ex: (faction01)',
                    'value' => '(global)'
                ]
            ])
            ->add('time', TextType::class, [
                'label' => 'Temps du ban',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 7d. Dénominateur valide m/h/d/M/y'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]+[mhdMy]{1}$/',
                        'message' => 'Le format doit être le temps + le dénominateur. Ex: 7d'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ban::class,
        ]);
    }
}
