<?php

namespace App\ControllerHandler\Moderation;

use App\Entity\Moderation\Mute;
use App\Repository\Moderation\MuteRepository;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MuteHandler
{
    private MuteRepository $muteRepository;

    public function __construct(
        MuteRepository $muteRepository
    )
    {
        $this->muteRepository = $muteRepository;
    }

    /**
     * @param FormInterface $form
     * @param Mute $mute
     * @param UserInterface $user
     * @return bool
     * @throws Exception
     */
    public function createMuteHandle(
        FormInterface $form,
        Mute $mute,
        UserInterface $user
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $timeForMute = $form->get('time')->getData();
            [$time, $denominator] = $this->timeFormat($timeForMute);

            $mute->setMuteStaff($user->getUserIdentifier());
            if ($timeForMute) {
                $mute->setMuteEnd(new DateTimeImmutable("+".$time.$denominator));
            }

            $this->muteRepository->save($mute);

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $form
     * @param Mute $mute
     * @return bool
     * @throws Exception
     */
    public function editMuteHandle(
        FormInterface $form,
        Mute $mute
    ): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $timeForMute = $form->get('time')->getData();
            [$time, $denominator] = $this->timeFormat($timeForMute);

            if ($timeForMute) {
                $mute->setMuteEnd(new DateTimeImmutable("+".$time.$denominator));
            }

            $this->muteRepository->update($mute);

            return true;
        }

        return false;
    }

    /**
     * @param Mute $mute
     * @return bool
     */
    public function deleteMuteHandle(
        Mute $mute
    ): bool
    {
        $this->muteRepository->remove($mute);

        return true;
    }

    /**
     * @param $timeForMute
     * @return array
     */
    private function timeFormat($timeForMute): array
    {
        $time = substr($timeForMute, 0, -1);
        $denominator = substr($timeForMute, -1);

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
        }

        return [$time, $denominator];
    }
}
