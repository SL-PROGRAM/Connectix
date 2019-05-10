<?php

namespace App\Controller;

use App\Entity\ProductionDirector;
use App\Form\ProductionDirectorType;
use App\Repository\ProductionDirectorRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productiondirector")
 * Class ProductionDirectorController
 * @package App\Controller
 */
class ProductionDirectorController extends AbstractController
{
    /**
     * @Route("/", name="production_director_index", methods={"GET"})
     * @param ProductionDirectorRepository $productionDirectorRepository
     * @return Response
     */
    public function index(ProductionDirectorRepository $productionDirectorRepository): Response
    {
        $socity = $this->getUser()->getSocity();
        return $this->render('production_director/index.html.twig', [
            'production_directors' => $productionDirectorRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="production_director_new", methods={"NEW", "POST", "GET"})
     */
    /**
     * @param Request $request
     * @return Response
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
                $productionDirector = new ProductionDirector();
                $coeficientSalary = 4.5;
                $formation = 75;
                $experience = 0;
                $productivity = $formation+$experience;
                $salary = $this->getUser()->getGame()->getSmic() * $coeficientSalary;
                $socity = $this->getUser()->getSocity();
                $productionActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.7;
                $administrationActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.3;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

                $productionDirector
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
                $entityManager->persist($productionDirector);
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
