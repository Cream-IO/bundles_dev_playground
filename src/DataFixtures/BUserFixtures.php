<?php

namespace App\DataFixtures;

use CreamIO\UserBundle\Entity\BUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BUserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new BUser();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPlainPassword('testPassword');
        $user->setDescription('Test decription');
        $user->setEmail('fixture@test.com');
        $user->setJob('Test Job');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUsername('TestUserName');
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }
}