<?php

namespace App\Controller;

use App\Entity\WorkMan;
use App\Form\WorkManType;
use App\Repository\ProductionRepository;
use App\Repository\WorkManRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/workman")
 */
class WorkManController extends AbstractController
{
    /**
     * @Route("/", name="work_man_index", methods={"GET"})
     */
    public function index(WorkManRepository $workManRepository): Response
    {
        return $this->render('work_man/index.html.twig', [
            'work_men' => $workManRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="work_man_new", methods={"NEW"})
     */
    public function new(Request $request): Response
    {
        $workMan = new WorkMan();
        $coeficientSalary = 1;
        $formation = 75;
        $experience = 0;
        $productivity = $formation+$experience;
        $salary = $this->getUser()->getGame()->getSmic() * $coeficientSalary;
        $socity = $this->getUser()->getSocity();
        $productionActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100;
        $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

        $workMan
            ->setProductionActivity($productionActivity)
            ->setAdministrationActivityCost($administrationActivityCost)
            ->setSocity($socity)
            ->setCoeficientSalary($coeficientSalary)
            ->setExprience($experience)
            ->setFormation($formation)
            ->setProductivity($productivity)
            ->setSalary($salary)
        ;


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($workMan);
        $entityManager->flush();

        return $this->redirectToRoute('player_human_ressourcies');
    }


}
