<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BalanceSheetController extends AbstractController
{
    /**
     * @Route("/balancesheet", name="balance_sheet")
     */
    public function index()
    {
        return $this->render('balance_sheet/index.html.twig', [
            'controller_name' => 'BalanceSheetController',
        ]);
    }
}
