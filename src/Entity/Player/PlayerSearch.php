<?php

namespace App\Entity\Player;

class PlayerSearch
{

    /**
     * @var Players
     */
    private $players;

    /**
     * @return Players|null
     */
    public function getPlayers(): ?Players
    {
        return $this->players;
    }

    /**
     * @param Players|null $players
     * @return $this
     */
    public function setPlayers(?Players $players): self
    {
        $this->players = $players;

        return $this;
    }
}
