<?php

namespace App\ControllerHandler\Moderation;

use App\Entity\Moderation\Kick;
use App\Repository\Moderation\KickRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface $user
     * @return bool
     */
    public function createKickHandle(
        FormInterface $form,
        Kick $kick,
        UserInterface $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $kick->setKickStaff($user->getUserIdentifier());

            $this->kickRepository->save($kick);

            return true;
        }

        return false;
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

    public function deleteKickHandle(
        Kick $kick
    )
    {
        $this->kickRepository->remove($kick);

        return true;
    }
}
