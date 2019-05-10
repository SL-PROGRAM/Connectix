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
 * Class UpSalaryController
 * @package App\Controller
 */
class UpSalaryController extends AbstractController
{
    /**
     * @Route("/Upsalaryadmin", name="administration_up_salary", methods={"GET","POST"})
     */
    /**
     * @param Request $request
     * @param AdministrationRepository $repository
     * @param \App\Service\UpSalary $up_salary
     * @return Response
     */
    public function up_salaryAdmin(Request $request, AdministrationRepository $repository, \App\Service\UpSalary $up_salary): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];

                $up_salary->salary($repository, $upSalary);
                return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'administrative'
        ]);

    }

    /**
     * @Route("/up_salaryresearcher", name="researcher_up_salary", methods={"GET","POST"})
     */
    /**
     * @param Request $request
     * @param ResearcherRepository $repository
     * @param \App\Service\UpSalary $up_salary
     * @return Response
     */
    public function upSalaryResearcher(Request $request, ResearcherRepository $repository, \App\Service\UpSalary $up_salary): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $upSalary = $dataform["number persons to up_salary"];


            $up_salary->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'research people'
        ]);

    }

    /**
     * @Route("/up_salaryprod", name="production_up_salary", methods={"GET","POST"})
     */
    /**
     * @param Request $request
     * @param ProductionRepository $repository
     * @param \App\Service\UpSalary $up_salary
     * @return Response
     */
    public function upSalaryProd(Request $request, ProductionRepository $repository, \App\Service\UpSalary $up_salary): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $up_salary->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'productive people'
        ]);

    }

    /**
     * @Route("/up_salarysales", name="salesman_up_salary", methods={"GET","POST"})
     */
    /**
     * @param Request $request
     * @param SalesManRepository $repository
     * @param \App\Service\UpSalary $up_salary
     * @return Response
     */
    public function upSalarySales(Request $request, SalesManRepository $repository, \App\Service\UpSalary $up_salary): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $up_salary->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);

    }

    /**
     * @Route("/up_salary", name="all_up_salary", methods={"GET","POST"})
     */
    /**
     * @param Request $request
     * @param HumanRessourceRepository $repository
     * @param \App\Service\UpSalary $up_salary
     * @return Response
     */
    public function upSalaryAll(Request $request, HumanRessourceRepository $repository, \App\Service\UpSalary $up_salary): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $upSalary = $dataform["number"];


            $up_salary->salary($repository, $upSalary);
            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);

    }


}
