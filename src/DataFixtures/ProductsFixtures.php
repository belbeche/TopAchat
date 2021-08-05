<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $product = array();

        for ($i = 0; $i < 10; $i++) {
            $product[$i] = new Product();
            $category = new Category();
            $product[$i]->setName($faker->name);
            $product[$i]->setDateTime((new \DateTime('now')));
            $product[$i]->setPrice($faker->numberBetween(0, 10000));
            $product[$i]->setDateFinGarantie(new \DateTime());
            $product[$i]->setCommentaires($faker->realText);
            $product[$i]->setManuel($faker->boolean);
            $product[$i]->setCategory($category);
            $product[$i]->setFilename($faker->imageUrl);
            $category->setName($faker->name);
            $product[$i]->setLieu($faker->name);
            $product[$i]->setUpdatedAt(new \DateTime('now'));
            $manager->persist($product[$i]);
        }

        $manager->flush();
    }
}
