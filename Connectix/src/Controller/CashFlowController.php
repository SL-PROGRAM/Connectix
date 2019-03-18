<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CashFlowController extends AbstractController
{
    /**
     * @Route("/cashflow", name="cash_flow")
     */
    public function index()
    {
        return $this->render('cash_flow/index.html.twig', [
            'controller_name' => 'CashFlowController',
        ]);
    }
}
