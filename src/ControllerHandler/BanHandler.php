<?php

namespace App\ControllerHandler;

use App\Entity\Moderation\Ban;
use App\Repository\Moderation\BanRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BanHandler
{
    private BanRepository $banRepository;

    public function __construct(
        BanRepository $banRepository
    )
    {
        $this->banRepository = $banRepository;
    }

    /**
     * @param FormInterface $form
     * @param Ban $ban
     * @param UserInterface $user
     * @return bool
     */
    public function createBanHandler(
        FormInterface $form,
        Ban $ban,
        UserInterface $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $timeForBan = $form->get('time')->getData();
            $time = substr($timeForBan, 0, -1);
            $denominator = substr($timeForBan, -1);

            switch ($denominator) {
                case "m":
                    $denominator = "minute";
                    break;
                case "h":
                    $denominator = "hour";
                    break;
                case "d":
                    $denominator = "day";
                    break;
                case "M":
                    $denominator = "month";
                    break;
                case "y":
                    $denominator = "year";
                    break;
            }

            $ban->setBanStaff($user->getUserIdentifier());
            if ($timeForBan) {
                $ban->setBanEnd(new \DateTimeImmutable("+".$time.$denominator));
            }

            $this->banRepository->save($ban);

            return true;
        }

        return false;
    }
}
