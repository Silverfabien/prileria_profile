<?php

namespace App\Form\Moderation;

use App\Entity\Moderation\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('appreciation')
            ->add('date')
            ->add('reportedUuid')
            ->add('reporterUuid')
            ->add('reason')
            ->add('reportedIp')
            ->add('reportedLocation')
            ->add('reportedMessages')
            ->add('reportedGamemode')
            ->add('reportedOnGround')
            ->add('reportedSneak')
            ->add('reportedSprint')
            ->add('ReportedHealth')
            ->add('reportedFood')
            ->add('reportedEffects')
            ->add('reporterIp')
            ->add('reporterLocation')
            ->add('reporterMessages')
            ->add('archived')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
