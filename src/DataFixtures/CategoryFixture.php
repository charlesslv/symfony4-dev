<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class CategoryFixture
 * @package App\DataFixtures
 */
class CategoryFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1; $i<4; $i++) {
            $categorie = new Category();
            $categorie->setName("Cat $i");
            $categorie->setDescription($faker->words("15", true));
            $manager->persist($categorie);

            // Reference d'access a cette categorie
            // par les autres classes fixtures
            $this->addReference("CAT_$i", $categorie);
        }
        $manager->flush();
    }
}
