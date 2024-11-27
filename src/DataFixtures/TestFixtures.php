<?php

namespace App\DataFixtures;

use App\Entity\Rappel;
use App\Entity\Categorie;
use Faker\Factory as FakerFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use function Symfony\Component\Clock\now;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $manager;

    public function __construct()
    {
        $this->faker = FakerFactory::create('fr_FR');
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void 
    {
        $this->manager = $manager;

        $this->loadCategories();
        $this->loadRappels();
    }

    public function loadCategories(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $categorie = new Categorie();
            $categorie->setNom($this->faker->word());
            $categorie->setDescription($this->faker->sentence());
            $this->manager->persist($categorie);
        }

        $this->manager->flush();
    }

    /**
     * Create 20 rappel entities with random values.
     */
/*************  ✨ Codeium Command ⭐  *************/
/******  3bb77010-67c7-4d9b-8a99-e65e0e5304fb  *******/
    public function loadRappels(): void
    {
      $categories = $this->manager->getRepository(Categorie::class)->findall();
      
      for ($i = 0; $i < 20; ++$i) {
        $rappel = new Rappel();
        $rappel->setTitre($this->faker->sentence(3));
        $rappel->setDescription($this->faker->sentence());
        $rappel->setDateRappel($this->faker->dateTimeBetween('now', '+1 year'));
        $rappel->setEstFait(false);
        $categorie = $this->faker->randomElement($categories);
        $rappel->setCategorie($categorie);
        $this->manager->persist($rappel);
      }
      
      $this->manager->flush();
    }

}
