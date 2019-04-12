<?php

namespace App\Controller;

use App\Entity\Researcher;
use App\Form\ResearcherType;
use App\Repository\ReseacherRepository;
use App\Repository\ResearcherRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/researcher")
 */
class ResearcherController extends AbstractController
{
    /**
     * @Route("/", name="researcher_index", methods={"GET"})
     */
    public function index(ResearcherRepository $reseacherRepository): Response
    {
        return $this->render('researcher/index.html.twig', [
            'researchers' => $reseacherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="researcher_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $researcher = new Researcher();
        $coeficientSalary = 2.5;
        $formation = 90;
        $experience = 0;
        $productivity = $formation+$experience;
        $smic = $this->getUser()->getGame()->getSmic();
        $salary = $coeficientSalary*$smic;
        $socity = $this->getUser()->getSocity();
        $researchActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100;
        $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

        $researcher
            ->setResearchActivity($researchActivity)
            ->setAdministrationActivityCost($administrationActivityCost)
            ->setSocity($socity)
            ->setCoeficientSalary($coeficientSalary)
            ->setExprience($experience)
            ->setFormation($formation)
            ->setProductivity($productivity)
            ->setSalary($salary)
        ;


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($researcher);
        $entityManager->flush();

        return $this->redirectToRoute('player_human_ressourcies');
    }

    /**
     * @Route("/dismiss", name="researcher_dismiss", methods={"GET","POST"})
     */
    public function dismissSalary(Request $request, ResearcherRepository $repository, Dismiss $dismiss): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $limit = $dataform["number persons to dismiss"];

            if($_GET['type'] === "Salary"){
                $dismiss->salary($repository, $limit);
                return $this->redirectToRoute('player_human_ressourcies');
            }

            if($_GET['type'] == "People") {
                $dismiss->people($repository, $limit);

                return $this->redirectToRoute('player_human_ressourcies');
            }
        }

        return $this->render('administration/new.html.twig', [
            'form' => $form->createView(),
            'people' => 'research people'
        ]);

    }
}
