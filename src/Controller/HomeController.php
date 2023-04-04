<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Plat;
use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @param Plat $plat
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     */
    #[Route('/home/{plat}', name: 'app_home')]
    public function index(Plat $plat, RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findAll();
        $plats = ['burger', 'pizza', 'glace'];

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants
        ]);
    }


    #[Route('/test', name: 'app_test')]
    public function test(RestaurantRepository $restaurantRepository): Response
    {
        $restaurant = new Restaurant();
        $adresse = new Address();
        $adresse->setName('12 riue lafayette');
        $restaurant->setName('Super nom');
        $restaurant->setDirector('Michel');
        $restaurant->setAddress($adresse);
    }


}
