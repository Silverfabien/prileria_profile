<?php

namespace App\ControllerHandler\Administration;

use App\Entity\Security\Rank;
use App\Repository\Security\RankRepository;
use Symfony\Component\Form\FormInterface;

class RankHandler
{
    private RankRepository $rankRepository;

    public function __construct(
        RankRepository $rankRepository
    )
    {
        $this->rankRepository = $rankRepository;
    }

    /**
     * @param FormInterface $form
     * @param Rank $rank
     * @return bool
     */
    public function editRankHandle(
        FormInterface $form,
        Rank $rank
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->rankRepository->update($rank);

            return true;
        }

        return false;
    }
}
