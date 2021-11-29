<?php

namespace App\Form\Player;

use App\Entity\Player\Players;
use App\Entity\Player\PlayerSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('players', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Players::class,
                'choice_label' => 'batPlayer',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayerSearch::class
        ]);
    }
}
