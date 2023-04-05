<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     */
    #[Route('/restaurant', name: 'app_restaurant')]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
         $restaurants = $restaurantRepository->findAll();

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @return Response
     */
    #[Route('/restaurant/find/{restaurant}', name: 'app_restaurant_id')]
    public function getId(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/getId.html.twig', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/restaurant/create', name: 'app_restaurant_create')]
    public function create(Request $request): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($restaurant);
            $this->em->flush();
            return $this->redirectToRoute('app_restaurant');
        }

        return $this->render('restaurant/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @param Request $request
     * @return Response
     */
    #[Route('/restaurant/update/{restaurant}', name: 'app_restaurant_update')]
    public function update(Restaurant $restaurant, Request $request): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($restaurant);
            $this->em->flush();
            return $this->redirectToRoute('app_restaurant');
        }
        return $this->render('restaurant/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @param Request $request
     * @return Response
     */
    #[Route('/restaurant/delete/{restaurant}', name: 'app_restaurant_delete')]
    public function delete(Restaurant $restaurant, Request $request): Response
    {
        $this->em->remove($restaurant);
        $this->em->flush();

        return $this->redirectToRoute("app_restaurant");
    }


}
