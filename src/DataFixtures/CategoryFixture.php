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
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 4; $i++) {
            $category = new Category();
            $category->setName("Cat $i");
            $category->setDescription($faker->realText('100'));
            $manager->persist($category);

            // Reference d'access a cette categorie
            // par les autres classes fixtures
            $this->addReference("CAT_$i", $category);
        }
        $manager->flush();
    }
}
