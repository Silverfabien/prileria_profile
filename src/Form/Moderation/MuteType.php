<?php

namespace App\Form\Moderation;

use App\Entity\Moderation\Mute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class MuteType extends AbstractType
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
            ->add('muteIp', TextType::class, [
                'label' => 'Ip du joueur',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 95.165.32.158'
                ]
            ])
            ->add('muteReason', TextType::class, [
                'label' => 'Raison du mute',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Insulte'
                ]
            ])
            ->add('muteServer', TextType::class, [
                'label' => 'Nom du serveur',
                'attr' => [
                    'placeholder' => 'Ex: (faction01)',
                    'value' => '(global)'
                ]
            ])
            ->add('time', TextType::class, [
                'label' => 'Temps du mute',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 7d. Dénominateur valide m/h/d'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]+[mhd]{1}$/',
                        'message' => 'Le format doit être le temps + le dénominateur. Ex: 7d'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mute::class,
        ]);
    }
}
