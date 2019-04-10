<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HumanRessourceScreenController extends AbstractController
{
    /**
     * @Route("/humanressourcescreen/production", name="human_ressource_screen_production")
     */
    public function production()
    {
        return $this->render('human_ressource_screen/production.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }

    /**
     * @Route("/humanressourcescreen/reseach", name="human_ressource_screen_research")
     */
    public function research()
    {
        return $this->render('human_ressource_screen/research.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }

    /**
     * @Route("/humanressourcescreen/sales", name="human_ressource_screen_sales")
     */
    public function sales()
    {
        return $this->render('human_ressource_screen/sales.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }
}
