<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    private EntityManagerInterface $em;
    private IngredientRepository $ingredientRepository;

    /**
     * @param EntityManagerInterface $em
     * @param IngredientRepository $ingredientRepository
     */
    public function __construct(EntityManagerInterface $em, IngredientRepository $ingredientRepository)
    {
        $this->em = $em;
        $this->ingredientRepository = $ingredientRepository;
    }

    #[Route('/ingredients', name: 'app_ingredient_all')]
    public function allIngredient(): Response
    {
        $ingredients = $this->ingredientRepository->findAll();
        return $this->render('ingredient/index.html.twig', [
            'ingredients' =>$ingredients
        ]);
    }

    #[Route('/ingredient/create', name: 'app_ingredient_create')]
    public function add(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($ingredient);
            $this->em->flush();
            return $this->redirectToRoute('app_ingredient_all');
        }

        return $this->render('ingredient/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
