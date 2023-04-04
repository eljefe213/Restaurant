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
        $ingredients = ['tomato', 'chess', 'speak'];
        $menus = ['midi', 'enfant', 'soir'];
        $plats = ['burger', 'pizza', 'glace'];

        $address = new Address();
        $address->setName('12 rue lafayette');
        $address->setZip(49100);
        $address->setCity('Angers');


        $restaurant = new Restaurant();
        $restaurant->setName('Pizza del arte');
        $restaurant->setDirector('Pierre');
        $restaurant->setAddress($address);

        foreach ($menus as $key => $menu) {
            $cart = new Menu();
            $cart->setName($menu);
            $cart->setPrice(12);
            $cart->setRestaurant($restaurant);

            $plat = new Plat();
            $plat->setRestaurant($restaurant);
            $plat->setPrice(5);
            $plat->setName($plats[$key]);

            foreach ($ingredients as $ingredient) {
                $ing = new Ingredient();
                $ing->setName($ingredient);
                $manager->persist($ing);

                $plat->addIngredient($ing);
            }
            $manager->persist($restaurant);
            $manager->persist($plat);
            $cart->addPlat($plat);

            $manager->persist($cart);

        }

        $manager->flush();
    }
}
