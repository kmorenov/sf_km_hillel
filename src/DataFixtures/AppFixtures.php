<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 9/10/18
 * Time: 6:42 PM
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $min_cat = 0;
        $max_cat = 5;
        //create 6 categories
        $categories = [];
        for ($i = $min_cat; $i <= $max_cat; $i++) {
            $category = new Category();
            $category->setTitle('Category ' . $i);
            $category->setDescription('Category Description ' . $i);

            $categories[] = $category;
            $manager->persist($category);
        }
        $manager->flush();

        // create 20 products
       for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle('title ' . $i);
            $article->setContent('content ' . $i);
            $article->setCreatedAt(new \DateTime('now'));
            $article->setCategory($categories[mt_rand($min_cat, $max_cat)]);
            $manager->persist($article);
        }
        $manager->flush();
    }
}