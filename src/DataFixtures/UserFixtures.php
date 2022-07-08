<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('contact@metagaleries.fr')
            ->setPassword($this->passwordEncoder->encodePassword($admin, '123456'))
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Matine')
            ->setLastName('NASSIRPOUR')
        ;

        $manager->persist($admin);
        $manager->flush();
    }
}
