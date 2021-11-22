<?php

namespace App\ControllerHandler\Administration;

use App\Entity\Player\Locked;
use App\Entity\Player\Players;
use App\Repository\Player\LockedRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LockedHandler
{
    private LockedRepository $lockedRepository;

    public function __construct(
        LockedRepository $lockedRepository
    )
    {
        $this->lockedRepository = $lockedRepository;
    }

    public function createLockedHandle(
        FormInterface $form,
        UserInterface $user,
        Locked $locked,
        Players $players
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $locked->setStaff($user->getUserIdentifier());
            $locked->setPlayer($players);

            $this->lockedRepository->save($locked);

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $form
     * @param Locked $locked
     * @return bool
     */
    public function editLockedHandle(
        FormInterface $form,
        Locked $locked
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->lockedRepository->update($locked);

            return true;
        }

        return false;
    }

    /**
     * @param Locked $locked
     * @return bool
     */
    public function deleteLockedHandle(
        Locked $locked
    ): bool
    {
        $this->lockedRepository->remove($locked);

        return true;
    }
}
