<?php

namespace App\ControllerHandler\Moderation;

use App\Entity\Moderation\Kick;
use App\Repository\Moderation\KickRepository;
use Symfony\Component\Form\FormInterface;

class KickHandler
{
    private KickRepository $kickRepository;

    public function __construct(
        KickRepository $kickRepository
    )
    {
        $this->kickRepository = $kickRepository;
    }

    /**
     * @param FormInterface $form
     * @param Kick $kick
     * @return bool
     */
    public function editKickHandle(
        FormInterface $form,
        Kick $kick
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->kickRepository->update($kick);

            return true;
        }

        return false;
    }

    /**
     * @param Kick $kick
     * @return bool
     */
    public function deleteKickHandle(
        Kick $kick
    ): bool
    {
        $this->kickRepository->remove($kick);

        return true;
    }
}
