<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

/**
 * Class AlbumFixture
 * @package App\DataFixtures
 */
class AlbumFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1; $i<10; $i++) {
            $album = new Album();
            $album->setName($faker->words("3", true));
            $album->setDescription($faker->words("150", true));
            $album->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0.99, $max = 65));
            $album->setCategory($this->getReference("CAT_".mt_rand(1,3)));
            $manager->persist($album);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [CategoryFixture::class];
    }
}
