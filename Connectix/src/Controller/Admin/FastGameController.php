<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\FastGameType;
use App\Repository\ProductRepository;
use App\Repository\SeasonalityRepository;
use App\Service\MakeProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fastgame")
 */
class FastGameController extends AbstractController
{


    /**
     * @Route("/new", name="fast_game_new", methods={"GET","POST"})
     */
    public function new(Request $request, MakeProduct $makeProduct, ProductRepository $productRepository, SeasonalityRepository $seasonalityRepository): Response
    {
        $game = new Game();
        $form = $this->createForm(FastGameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game->setRawMaterialMax(10);
            $game->setRawMaterialMin(10);
            $game->setCreatAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            $makeProduct->products($game, $productRepository, $seasonalityRepository);

            return $this->redirectToRoute('socity_new', ['gameid' => $game->getId()]);
        }

        return $this->render('game/fast_new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
            'value' => "Game"
        ]);
    }

}
