<?php

namespace App\ControllerHandler\Moderation;

use App\Entity\Moderation\Comments;
use App\Repository\Moderation\CommentsRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentsHandler
{
    private CommentsRepository $commentsRepository;

    public function __construct(
        CommentsRepository $commentsRepository
    )
    {
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * @param FormInterface $form
     * @param Comments $comments
     * @param UserInterface $user
     * @return bool
     */
    public function createCommentsHandle(
        FormInterface $form,
        Comments $comments,
        UserInterface $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $comments->setStaff($user->getUserIdentifier());

            $this->commentsRepository->save($comments);

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $form
     * @param Comments $comments
     * @return bool
     */
    public function editCommentsHandle(
        FormInterface $form,
        Comments $comments
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentsRepository->update($comments);

            return true;
        }

        return false;
    }

    /**
     * @param Comments $comments
     * @return bool
     */
    public function deleteCommentsHandle(
        Comments $comments
    ): bool
    {
        $this->commentsRepository->remove($comments);

        return true;
    }
}
