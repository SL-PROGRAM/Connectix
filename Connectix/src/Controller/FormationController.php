<?php

namespace App\Controller;


use App\Repository\AdministrationRepository;
use App\Repository\ProductionRepository;
use App\Repository\HumanRessourceRepository;
use App\Repository\ResearcherRepository;
use App\Repository\SalesManRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FormationController
 * @package App\Controller
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/formationadmin", name="administration_formation", methods={"GET","POST"})
     * @param Request $request
     * @param AdministrationRepository $repository
     * @param \App\Service\Formation $formation
     * @return Response
     */
    public function formationAdmin(Request $request, AdministrationRepository $repository, \App\Service\Formation $formation): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];

            $formation->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('formation/formation.html.twig', [
            'form' => $form->createView(),
            'people' => 'administrative'
        ]);

    }

    /**
     * @Route("/formationresearcher", name="researcher_formation", methods={"GET","POST"})
     * @param Request $request
     * @param ResearcherRepository $repository
     * @param \App\Service\Formation $formation
     * @return Response
     */
    public function upSalaryResearcher(Request $request, ResearcherRepository $repository, \App\Service\Formation $formation): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $upSalary = $dataform["number persons to formation"];


            $formation->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('formation/formation.html.twig', [
            'form' => $form->createView(),
            'people' => 'research people'
        ]);

    }

    /**
     * @Route("/formationprod", name="production_formation", methods={"GET","POST"})
     * @param Request $request
     * @param ProductionRepository $repository
     * @param \App\Service\Formation $formation
     * @return Response
     */
    public function upSalaryProd(Request $request, ProductionRepository $repository, \App\Service\Formation $formation): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $formation->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('formation/formation.html.twig', [
            'form' => $form->createView(),
            'people' => 'productive people'
        ]);

    }

    /**
     * @Route("/formationsalesman", name="salesman_formation", methods={"GET","POST"})
     * @param Request $request
     * @param SalesManRepository $repository
     * @param \App\Service\Formation $formation
     * @return Response
     */
    public function upSalarySales(Request $request, SalesManRepository $repository, \App\Service\Formation $formation): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $formation->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('formation/formation.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);

    }

    /**
     * @Route("/formation", name="all_formation", methods={"GET","POST"})
     * @param Request $request
     * @param HumanRessourceRepository $repository
     * @param \App\Service\Formation $formation
     * @return Response
     */
    public function upSalaryAll(Request $request, HumanRessourceRepository $repository, \App\Service\Formation $formation): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $formation->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('formation/formation.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);
    }
}
