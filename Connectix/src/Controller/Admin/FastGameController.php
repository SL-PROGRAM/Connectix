<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\FastGameType;
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
    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(FastGameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game->setRawMaterialMax(10);
            $game->setRawMaterialMin(10);
            $game->setCreatAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();

            $socities = $game->getSocities();
            dump($socities);
            foreach ($socities as $socity){
                dump($socity);
                $socity->setPriceMaxPublicityImpact(1);
                $socity->setPriceMinPublicicyImpact(1);
                $socity->setGame($game);
                $entityManager->persist($socity);

            }

            dump($form->getData());

            $entityManager->persist($game);



            $entityManager->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/fast_new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
            'value' => "Game"
        ]);
    }

}
