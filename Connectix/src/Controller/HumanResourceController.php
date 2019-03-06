<?php

namespace App\Controller;

use App\Entity\Technician;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HumanResourceController extends AbstractController
{
    /**
     * @Route("/humanresource", name="human_resource")
     */
    public function index()
    {
        return $this->render('human_resource/index.html.twig', [
            'controller_name' => 'HumanResourceController',
        ]);
    }

    public function makeTechnician($salary, $formation, $exprience, $productivity, $administrationActivityCost, $coeficientSalary, $productionActivity, $administationActivity){
        $entityManager = $this->getDoctrine()->getManager();

        $technician = new Technician();

        $technician     ->setAdministrationActivity(10)
                        ->setSalary(1000)
                        ->setFormation(100)
                        ->setProductivity(100)
                        ->setExprience(2)
                        ->setAdministrationActivityCost(100)
                        ->setCoeficientSalary(1.2)
                        ->setProductionActivity(100);

        $entityManager  ->persist($technician);
        $entityManager  ->flush();

    }

}
