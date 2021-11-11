<?php

namespace App\Form\Moderation;

use App\Entity\Moderation\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entity', TextType::class, [
                'label' => 'Uuid du joueur',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: af860b2e418411ec81d30242ac130003',
                    'autofocus' => true
                ]
            ])
            ->add('note', TextType::class, [
                'label' => 'Raison du warn/note',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Il a fly devant moi'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'choices' => [
                    'Warn' => 'WARNING',
                    'Note' => 'NOTE'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
