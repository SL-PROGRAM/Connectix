<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'socity' => $socity,
            'turn' => $turn,
        ]);
    }
}
