<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Ingredient;
use App\Entity\Menu;
use App\Entity\Plat;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredientsItems = ['tomate', 'champignon', 'emmental', 'jambon', 'chevre', 'merguez', 'olive'];
        $ingredients = [];

        foreach ($ingredientsItems as $item) {
            $ingredient = new Ingredient();
            $ingredient->setName($item);
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        $address1 = new Address();
        $address1->setName('12 place des oliviers');
        $address1->setZip(75014);
        $address1->setCity("Paris");

        $address2 = new Address();
        $address2->setName('1 square Alfred Musset');
        $address2->setZip(75012);
        $address2->setCity("Paris");

        $restaurantsItems = [
            [
                "name" => "pizzeria Sicile",
                "address" => $address1,
                "director" => "Luigi",
                "plats" => [
                    'reine' => [
                        'price' => 10,
                        'ingredients' => [$ingredients[1], $ingredients[3], $ingredients[4]],
                    ],
                    'saumon' => [
                        'price' => 11,
                        'ingredients' => [$ingredients[2], $ingredients[5], $ingredients[1]],
                    ],
                    'chevres miel' => [
                        'price' => 12,
                        'ingredients' => [$ingredients[0], $ingredients[2], $ingredients[4]],
                    ],
                    'vegetariennes' => [
                        'price' => 14,
                        'ingredients' => [$ingredients[4], $ingredients[1], $ingredients[5]],
                    ],
                    'oriental' => [
                        'price' => 15,
                        'ingredients' => [$ingredients[3], $ingredients[2], $ingredients[6]],
                    ]
                ],
                "menus" => [
                    [
                        "name" => "midi",
                        "plat" => ["reine", 'saumon'],
                        "price" => 19
                    ]
                ]
            ],
            [
                "name" => "pizzeria Napoli",
                "address" => $address2,
                "director" => "Mario",
                "plats" => [
                    'reine' => [
                        'price' => 10,
                        'ingredients' => [$ingredients[5], $ingredients[3], $ingredients[2]],
                    ],
                    '4 fromages' => [
                        'price' => 11,
                        'ingredients' => [$ingredients[2], $ingredients[4], $ingredients[0]],
                    ],
                    'vegetariennes' => [
                        'price' => 13,
                        'ingredients' => [$ingredients[2], $ingredients[3], $ingredients[6]],
                    ],
                ],
                "menus" => [
                    [
                        "name" => "midi",
                        "plat" => ["reine", '4 fromages'],
                        "price" => 21
                    ]
                ]

            ]
        ];

        foreach ($restaurantsItems as $item) {

            $restaurant = new Restaurant();
            $restaurant->setName($item["name"]);
            $restaurant->setAddress($item['address']);
            $restaurant->setDirector($item['director']);

            foreach ($item['plats'] as $name => $platItem) {
                $plat = new Plat();
                $plat->setName($name);
                $plat->setPrice($platItem['price']);
                foreach ($platItem['ingredients'] as $ingredientItem) {
                    $plat->addIngredient($ingredientItem);
                }
                $restaurant->addPlat($plat);
                $manager->persist($plat);

            }
            foreach ($item['menus'] as $menuItem) {
                $menu = new Menu();
                $menu->setName($menuItem['name']);
                $menu->setPrice($menuItem['price']);
                foreach ($menuItem['plat'] as $itemMenuPlat) {
                    foreach ($restaurant->getPlats() as $platResto) {
                        if($platResto->getName() === $itemMenuPlat){
                            $menu->addPlat($platResto);
                        }
                    }
                }
                $restaurant->addMenu($menu);
            }
              $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
