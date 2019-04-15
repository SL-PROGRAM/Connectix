<?php

namespace App\Controller;

use App\Entity\SalesManDirector;
use App\Form\SalesManDirectorType;
use App\Repository\SalesManDirectorRepository;
use App\Repository\SalesManRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmandirector")
 */
class SalesManDirectorController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_director_index", methods={"GET"})
     */
    public function index(SalesManDirectorRepository $salesManDirectorRepository): Response
    {
        return $this->render('sales_man_director/index.html.twig', [
            'sales_man_directors' => $salesManDirectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_director_new", methods={"NEW", "POST", "GET"})
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
                $salesManDirector = new SalesManDirector();
                $coeficientSalary = 1.5;
                $formation = 80;
                $experience = 0;
                $commission = 3;
                $productivity = $formation+$experience;
                $smic = $this->getUser()->getGame()->getSmic();
                $salary = $coeficientSalary*$smic;
                $socity = $this->getUser()->getSocity();
                $salesActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.7;
                $administrationActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.3;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

                $salesManDirector
                    ->setAdministrationActivity($administrationActivity)
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
                $entityManager->persist($salesManDirector);
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
