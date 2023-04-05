<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Restaurant;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/plats', name: 'app_plat')]
    public function index(): Response
    {
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }


    #[Route('/restaurant/plat/create/{restaurant}', name: 'app_plat_create')]
    public function createPlat(Restaurant $restaurant, Request $request): Response
    {
        $plat = new Plat();
        $plat->setRestaurant($restaurant);
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($plat);
            $this->em->flush();

            return $this->redirectToRoute('app_restaurant_id', ['restaurant' => $restaurant->getId()]);
        }
        return $this->render('plat/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
