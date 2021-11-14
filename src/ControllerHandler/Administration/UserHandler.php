<?php

namespace App\ControllerHandler\Administration;

use App\Entity\Security\User;
use App\Repository\Security\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHandler
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     */
    public function createUserHandle(
        FormInterface $form,
        User $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->hashPassword($user, $user->getPassword());

            $user->setPassword($password);

            $this->userRepository->save($user);

            return true;
        }

        return false;
    }

    public function editUserHandle(
        FormInterface $form,
        User $user
    )
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->update($user);

            return true;
        }

        return false;
    }

    public function editUserPasswordHandle(
        FormInterface $form,
        User $user
    )
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->hashPassword($user, $user->getPassword());

            $user->setPassword($password);

            $this->userRepository->update($user);

            return true;
        }

        return false;
    }
}
