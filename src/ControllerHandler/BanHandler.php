<?php

namespace App\ControllerHandler;

use App\Entity\Moderation\Ban;
use App\Repository\Moderation\BanRepository;
use DateTimeImmutable;
use Exception;
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
     * @throws Exception
     */
    public function createBanHandle(
        FormInterface $form,
        Ban $ban,
        UserInterface $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $timeForBan = $form->get('time')->getData();
            [$time, $denominator] = $this->timeFormat($timeForBan);

            $ban->setBanStaff($user->getUserIdentifier());
            if ($timeForBan) {
                $ban->setBanEnd(new DateTimeImmutable("+".$time.$denominator));
            }

            $this->banRepository->save($ban);

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $form
     * @param Ban $ban
     * @return bool
     * @throws Exception
     */
    public function editBanHandle(
        FormInterface $form,
        Ban $ban
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $timeForBan = $form->get('time')->getData();
            [$time, $denominator] = $this->timeFormat($timeForBan);

            if ($timeForBan) {
                $ban->setBanEnd(new DateTimeImmutable("+".$time.$denominator));
            }

            $this->banRepository->update($ban);

            return true;
        }

        return false;
    }

    /**
     * @param Ban $ban
     * @return bool
     */
    public function deleteBanHandle(
        Ban $ban
    ): bool
    {
        $this->banRepository->remove($ban);

        return true;
    }

    /**
     * @param $timeForBan
     * @return array
     */
    private function timeFormat($timeForBan): array
    {
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

        return [$time, $denominator];
    }
}
