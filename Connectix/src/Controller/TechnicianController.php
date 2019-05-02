<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Form\TechnicianType;
use App\Repository\TechnicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/technician")
 */
class TechnicianController extends AbstractController
{
    /**
     * @Route("/", name="technician_index", methods={"GET"})
     */
    public function index(TechnicianRepository $technicianRepository): Response
    {
        $socity = $this->getUser()->getSocity();
        return $this->render('technician/index.html.twig', [
            'technicians' => $technicianRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="technician_new", methods={"NEW", "POST", "GET"})
     */
    public function new(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $number = $dataform["number"];

            for ($i=0; $i < $number; $i++) {
                $technician = new Technician();
                $coeficientSalary = 1.8;
                $formation = 75;
                $experience = 0;
                $productivity = $formation+$experience;
                $salary = $this->getUser()->getGame()->getSmic() * $coeficientSalary;
                $socity = $this->getUser()->getSocity();
                $productionActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.9;
                $administrationActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.1;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

                $technician
                    ->setAdministrationActivity($administrationActivity)
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
                $entityManager->persist($technician);
            }

            $entityManager->flush();

            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'admin'
        ]);
    }
}
