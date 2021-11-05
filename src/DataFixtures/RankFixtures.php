<?php

namespace App\DataFixtures;

use App\Entity\Security\Rank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RankFixtures extends Fixture
{
    const RANK_REFERENCE = "Rank";

    public function load(ObjectManager $manager)
    {
        $rankData = [
            [
                "Adminsitrateur",
                ["ROLE_ADMIN"]
            ],
            [
                "Responsable",
                ["ROLE_RESP"]
            ],
            [
                "Staff",
                ["ROLE_STAFF"]
            ]
        ];

        $i = 0;

        foreach ($rankData as list($roleName, $role)) {
            $rank = new Rank();
            $rank->setRolename($roleName);
            $rank->setRole($role);

            $manager->persist($rank);
            $manager->flush();

            $this->addReference(self::RANK_REFERENCE.$i, $rank);
            $i++;
        }
    }
}
