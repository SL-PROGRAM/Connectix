<?php

namespace App\Controller;

use App\Entity\SalesManParticular;
use App\Form\SalesManParticularType;
use App\Repository\SalesManParticularRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmanparticular")
 */
class SalesManParticularController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_particular_index", methods={"GET"})
     */
    public function index(SalesManParticularRepository $salesManParticularRepository): Response
    {
        return $this->render('sales_man_particular/index.html.twig', [
            'sales_man_particulars' => $salesManParticularRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_particular_new", methods={"NEW"})
     */
    public function new(Request $request): Response
    {
        $salesManParticular = new SalesManParticular();
        $coeficientSalary = 1.5;
        $formation = 70;
        $experience = 0;
        $commission = 3;
        $productivity = $formation+$experience;
        $smic = $this->getUser()->getGame()->getSmic();
        $salary = $coeficientSalary*$smic;
        $socity = $this->getUser()->getSocity();
        $salesActivityParticular = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.8;
        $salesActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.2;
        $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

        $salesManParticular
            ->setSalesActivityParticular($salesActivityParticular)
            ->setSalesActivity($salesActivity)
            ->setCommission($commission)
            ->setAdministrationActivityCost($administrationActivityCost)
            ->setSocity($socity)
            ->setCoeficientSalary($coeficientSalary)
            ->setExprience($experience)
            ->setFormation($formation)
            ->setProductivity($productivity)
            ->setSalary($salary)
        ;


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($salesManParticular);
        $entityManager->flush();

        return $this->redirectToRoute('player_human_ressourcies');
    }
}
