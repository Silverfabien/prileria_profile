<?php

namespace App\Form\Administration;

use App\Entity\Player\Locked;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LockedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reason', TextType::class, [
                'label' => 'Raison du blocage',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Raison du blocage du profil',
                    'autofocus' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Locked::class,
        ]);
    }
}
