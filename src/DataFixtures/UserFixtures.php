<?php

namespace App\DataFixtures;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;
    private TokenGeneratorInterface $tokenGenerator;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function __construct(
        UserPasswordHasherInterface $passwordEncoder,
        TokenGeneratorInterface $tokenGenerator
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function load(ObjectManager $manager)
    {
        $userData = [
            [
                $this->getReference(RankFixtures::RANK_REFERENCE.'0'),
                "Admin",
                "Admin"
            ],
            [
                $this->getReference(RankFixtures::RANK_REFERENCE.'1'),
                "Responsable",
                "Responsable"
            ],
            [
                $this->getReference(RankFixtures::RANK_REFERENCE.'2'),
                "Staff",
                "Staff"
            ]
        ];

        foreach ($userData as list($rank, $username, $password)) {
            $user = new User();
            $user->setRank($rank);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->hashPassword($user, $password));

            $manager->persist($user);
            $manager->flush();
        }
    }

    public function getDepedencies()
    {
        return [RankFixtures::class];
    }

}
