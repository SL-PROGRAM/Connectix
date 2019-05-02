<?php

namespace App\Controller;

use App\Entity\SalesManProfessional;
use App\Repository\SalesManProfessionalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        $socity = $this->getUser()->getSocity();
        return $this->render('sales_man_professional/index.html.twig', [
            'sales_man_professionals' => $salesManProfessionalRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_professional_new", methods={"NEW", "POST", "GET"})
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
