<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
  private const NB_ARTICLES = 120;
  private const NB_CATEGORIES = 15;
  private const NB_TAGS = 35;

  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create("zh_TW");

    $categories = [];

    for ($i = 0; $i < self::NB_CATEGORIES; $i++) {
      $category = new Category();
      $category->setName($faker->word());

      $manager->persist($category);
      $categories[] = $category;
    }

    $tags = [];

    for ($i = 0; $i < self::NB_TAGS; $i++) {
      $tag = new Tag();
      $tag->setName($faker->word());

      $manager->persist($tag);
      $tags[] = $tag;
    }

    for ($i = 1; $i <= self::NB_ARTICLES; $i++) {
      $article = new Article();
      $article
        // ->setTitle($faker->realTextBetween(20, 40))
        ->setTitle($faker->words($faker->numberBetween(3, 7), true))
        ->setContent($faker->realText(600))
        ->setDateCreated($faker->dateTimeBetween('-2 years'))
        ->setVisible($faker->boolean(80))
        ->setCategory(
          $faker->randomElement($categories)
        );

      $nbTags = $faker->numberBetween(1, 8);

      for ($j = 0; $j < $nbTags; $j++) {
        $article->addTag($faker->randomElement($tags));
      }

      $manager->persist($article);
    }

    $manager->flush();
  }
}
