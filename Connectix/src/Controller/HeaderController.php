<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HeaderController
 * @package App\Controller
 */
class HeaderController extends AbstractController
{
    /**
     * @Route("/header", name="header")
     */
    public function index()
    {
        return $this->render('header/index.html.twig', [
            'controller_name' => 'HeaderController',
        ]);
    }
}
