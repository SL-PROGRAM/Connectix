<?php

namespace App\Controller;

use App\Entity\ResearcherDirector;
use App\Form\ResearcherDirectorType;
use App\Repository\ResearcherDirectorRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/researcherdirector")
 * Class ResearcherDirectorController
 * @package App\Controller
 */
class ResearcherDirectorController extends AbstractController
{
    /**
     * @Route("/", name="researcher_director_index", methods={"GET"})
     * @param ResearcherDirectorRepository $researcherDirectorRepository
     * @return Response
     */
    public function index(ResearcherDirectorRepository $researcherDirectorRepository): Response
    {
        $socity = $this->getUser()->getSocity();
        return $this->render('researcher_director/index.html.twig', [
            'researcher_directors' => $researcherDirectorRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="researcher_director_new", methods={"NEW", "POST", "GET"})
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
                $researcherDirector = new ResearcherDirector();
                $coeficientSalary = 5.5;
                $formation = 90;
                $experience = 0;
                $productivity = $formation + $experience;
                $smic = $this->getUser()->getGame()->getSmic();
                $salary = $coeficientSalary * $smic;
                $socity = $this->getUser()->getSocity();
                $researchActivity = $this->getUser()->getGame()->getAnnualHoursWork() * $productivity / 100 * 0.8;
                $administrationActivity = $this->getUser()->getGame()->getAnnualHoursWork() * $productivity / 100 * 0.2;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork() / 50;

                $researcherDirector
                    ->setAdministrationActivity($administrationActivity)
                    ->setResearchActivity($researchActivity)
                    ->setAdministrationActivityCost($administrationActivityCost)
                    ->setSocity($socity)
                    ->setCoeficientSalary($coeficientSalary)
                    ->setExprience($experience)
                    ->setFormation($formation)
                    ->setProductivity($productivity)
                    ->setSalary($salary);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($researcherDirector);
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
