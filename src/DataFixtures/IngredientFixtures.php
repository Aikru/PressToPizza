<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ingredientsToCreate = [
            "Base sauce tomate",
            "Base crème fraiche",
            "Lardons",
            "Mozzarella",
            "Poulet",
            "Viande hachée",
            "Poivrons",
            "Fromage raclette",
            "Jambon",
            "Champignons",
            "Thon",
            "Olives",
            "Oeuf",
            "Merguez",
            "Brie",
            "Bleu",
            "Chèvre",
            "Parmesan",
            "Oignons",
            "Pommes de terre",
            "Miel",
            "Fromage tartiflette",
        ];

        foreach ($ingredientsToCreate as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->setName($ingredientName);
            $this->addReference('ingredient-' . $ingredientName, $ingredient);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}