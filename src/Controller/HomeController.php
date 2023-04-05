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
    #[Route('/', name: 'app_home')]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findAll();

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants
        ]);
    }

    #[Route('/chocolat', name: 'app_racine')]
    public function superTest(): Response
    {
        dd("hello world");
    }


}
