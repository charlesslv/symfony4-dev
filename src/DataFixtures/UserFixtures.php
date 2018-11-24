<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var $encoder
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("sadmin@gmail.com");
        $user->setPassword($this->encoder->encodePassword($user, "sadmin"));
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("admin@gmail.com");
        $user->setPassword($this->encoder->encodePassword($user, "admin"));
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("author@gmail.com");
        $user->setPassword($this->encoder->encodePassword($user, "author"));
        $user->setRoles(["ROLE_AUTHOR"]);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user@gmail.com");
        $user->setPassword($this->encoder->encodePassword($user, "user"));
        $user->setRoles([]);
        $manager->persist($user);

        $manager->flush();
    }
}
