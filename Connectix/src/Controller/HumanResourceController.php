<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\ProductionDirector;
use App\Entity\Socity;
use App\Entity\Technician;
use App\Entity\HumanResource;
use App\Entity\WorkMan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HumanResourceController extends AbstractController
{
    /**
     * @Route("/humanresource", name="human_resource")
     */
    public function index()
    {
        $this->makeGame();
        $this->makeSocity();

        return $this->render('human_resource/index.html.twig', [
            'controller_name' => 'HumanResourceController',
        ]);
    }

    /**
     * @see function call to create a new game
     */
    public function makeGame(){
        $entityManager = $this->getDoctrine()->getManager();
        $game = new Game();

        $game   ->setName('bob')
                ->setCreatAt(new \DateTime())
                ->setMaxturn(20)
                ->setSmic(1500)
                ->setSocityNumber(5)
                ->setTurn(0)
                ->setTva(20);
        $entityManager  ->persist($game);
        $entityManager  ->flush();
    }


    /**
     * @see function call to create a new socity
     */
    public function makeSocity(){
        $entityManager = $this->getDoctrine()->getManager();

        $socity = new Socity();

        $socity ->setName('bob')
                ->setMoneyStart(10000)
                ->setPriceMaxPublicityImpact(100000)
                ->setPriceMinPublicicyImpact(1000);

        $entityManager  ->persist($socity);
        $entityManager  ->flush();
    }

    public function makeTechnician(Socity $socity, $administrationActivity, $productionActivity, $formation, $productivity, $experience, $administrationActivityCost, $coeficientSalary){

        $entityManager = $this->getDoctrine()->getManager();

        $salary = $this->baseSalary()*$coeficientSalary;

        $technician = new Technician();

        $technician     ->setAdministrationActivity($administrationActivity)
                        ->setProductionActivity($productionActivity)
                        ->setSalary($salary)
                        ->setFormation($formation)
                        ->setProductivity($productivity)
                        ->setExprience($experience)
                        ->setAdministrationActivityCost($administrationActivityCost)
                        ->setCoeficientSalary($coeficientSalary)
                        ->setSocity($socity);


        $entityManager  ->persist($technician);
        $entityManager  ->flush();

    }

    public function makeWorMan(Socity $socity, $productionActivity, $salary, $formation, $productivity, $experience, $administrationActivityCost, $coeficientSalary){

        $entityManager = $this->getDoctrine()->getManager();


        $technician = new WorkMan();

        $technician     ->setProductionActivity($productionActivity)
                        ->setSalary($salary)
                        ->setFormation($formation)
                        ->setProductivity($productivity)
                        ->setExprience($experience)
                        ->setAdministrationActivityCost($administrationActivityCost)
                        ->setCoeficientSalary($coeficientSalary)
                        ->setSocity($socity);


        $entityManager  ->persist($technician);
        $entityManager  ->flush();

    }

    public function makeProductionDirector(Socity $socity, $administrationActivity, $productionActivity, $salary, $formation, $productivity, $experience, $administrationActivityCost, $coeficientSalary){

        $entityManager = $this->getDoctrine()->getManager();


        $technician = new ProductionDirector();

        $technician     ->setAdministrationActivity($administrationActivity)
            ->setProductionActivity($productionActivity)
            ->setSalary($salary)
            ->setFormation($formation)
            ->setProductivity($productivity)
            ->setExprience($experience)
            ->setAdministrationActivityCost($administrationActivityCost)
            ->setCoeficientSalary($coeficientSalary)
            ->setSocity($socity);


        $entityManager  ->persist($technician);
        $entityManager  ->flush();

    }


    public function baseSalary(){
        $user = $this->getUser();
        $game = $user->getGame();

        return $smic = $game->getSmic();
    }



}


