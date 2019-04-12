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


class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="administration_formation", methods={"GET","POST"})
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
     * @Route("/formation", name="researcher_formation", methods={"GET","POST"})
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
     * @Route("/formation", name="production_formation", methods={"GET","POST"})
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
     * @Route("/formation", name="salesman_formation", methods={"GET","POST"})
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
