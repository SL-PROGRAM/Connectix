<?php

namespace App\Controller;

use App\Entity\SalesManProfessional;
use App\Form\SalesManProfessionalType;
use App\Repository\SalesManProfessionalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmanprofessional")
 */
class SalesManProfessionalController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_professional_index", methods={"GET"})
     */
    public function index(SalesManProfessionalRepository $salesManProfessionalRepository): Response
    {
        return $this->render('sales_man_professional/index.html.twig', [
            'sales_man_professionals' => $salesManProfessionalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_professional_new", methods={"NEW"})
     */
    public function new(Request $request): Response
    {
        $salesManProfessional = new SalesManProfessional();
        $coeficientSalary = 1.5;
        $formation = 70;
        $experience = 0;
        $commission = 3;
        $productivity = $formation+$experience;
        $smic = $this->getUser()->getGame()->getSmic();
        $salary = $coeficientSalary*$smic;
        $socity = $this->getUser()->getSocity();
        $salesActivityProfessional = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.8;
        $salesActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.2;
        $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

        $salesManProfessional
            ->setSalesActivityProfessional($salesActivityProfessional)
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
        $entityManager->persist($salesManProfessional);
        $entityManager->flush();

        return $this->redirectToRoute('player_human_ressourcies');
    }

}
