<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    public function index()
    {
        return $this->render('start_game/index.html.twig', [
            'controller_name' => 'StartGameController',
        ]);
    }
}
