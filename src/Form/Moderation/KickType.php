<?php

namespace App\Form\Moderation;

use App\Entity\Moderation\Kick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid', TextType::class, [
                'label' => 'Uuid du joueur',
                'attr' => [
                    'placeholder' => 'Ex: af860b2e418411ec81d30242ac130003',
                    'autofocus' => true
                ]
            ])
            ->add('kickReason', TextType::class, [
                'label' => 'Raison du kick',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Insulte'
                ]
            ])
            ->add('kickServer', TextType::class, [
                'label' => 'Nom du serveur',
                'attr' => [
                    'placeholder' => 'Ex: (faction01)',
                    'value' => '(global)'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Kick::class,
        ]);
    }
}
