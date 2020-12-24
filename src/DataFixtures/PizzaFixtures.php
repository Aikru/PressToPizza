<?php

namespace App\DataFixtures;

use App\Entity\Pizza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PizzaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $pizzasToCreate = [
            [
                "name" => "Reine",
                "description" => "La reine des pizzas. Indétrônable.",
                "price" => 9.99,
                "ingredients" => ["Base sauce tomate", "Mozzarella", "Jambon", "Champignons"]
            ],
            [
                "name" => "Orientale",
                "description" => "Elle vous accompagnera durant vos 1001 folies.",
                "price" => 12.99,
                "ingredients" => ["Base sauce tomate", "Mozzarella", "Merguez", "Oeuf", "Poivrons", "Olives"]
            ],
            [
                "name" => "Raclette",
                "description" => "Une raclette avec tes raquettes.",
                "price" => 11.99,
                "ingredients" => ["Base crème fraiche", "Mozzarella", "Lardons", "Pommes de terre", "Oignons", "Fromage raclette"]
            ],
            [
                "name" => "Tartiflette",
                "description" => "Très bonne pizza",
                "price" => 13.99,
                "ingredients" => ["Base crème fraiche", "Mozzarella", "Lardons", "Pommes de terre", "Oignons", "Fromage tartiflette"]
            ],
        ];
        foreach ($pizzasToCreate as $pizzaContent) {
            $pizza = new Pizza();
            $pizza->setName($pizzaContent["name"]);
            $pizza->setDescription($pizzaContent["description"]);
            $pizza->setPrice($pizzaContent["price"]);
            $pizza->setIsAvailable(true);
            foreach ($pizzaContent["ingredients"] as $ingredientName) {
                $ingredientToAdd = $this->getReference('ingredient-' . $ingredientName);
                $pizza->addIngredient($ingredientToAdd);
            }

            $manager->persist($pizza);
        }
        

        $manager->flush();
    }

}