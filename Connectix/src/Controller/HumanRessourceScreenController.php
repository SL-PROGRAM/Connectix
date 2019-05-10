<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HumanRessourceScreenController
 * @package App\Controller
 */
class HumanRessourceScreenController extends AbstractController
{
    /**
     * @Route("/humanressourcescreen/production", name="human_ressource_screen_production")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function production()
    {
        return $this->render('human_ressource_screen/production.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }

    /**
     * @Route("/humanressourcescreen/reseach", name="human_ressource_screen_research")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function research()
    {
        return $this->render('human_ressource_screen/research.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }

    /**
     * @Route("/humanressourcescreen/sales", name="human_ressource_screen_sales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sales()
    {
        return $this->render('human_ressource_screen/sales.html.twig', [
            'controller_name' => 'HumanRessourceScreenController',
        ]);
    }
}
