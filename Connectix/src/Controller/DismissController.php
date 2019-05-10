<?php


namespace App\Controller;


use App\Repository\AdministrationRepository;
use App\Repository\HumanRessourceRepository;
use App\Repository\ProductionRepository;
use App\Repository\ResearcherRepository;
use App\Repository\SalesManRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DismissController
 * @package App\Controller
 */
class DismissController extends AbstractController
{
    /**
     * @Route("/dismissadmin", name="administration_dismiss", methods={"GET","POST"})
     * @param Request $request
     * @param AdministrationRepository $repository
     * @param \App\Service\Dismiss $dismiss
     * @return Response
     */
    public function dismissAdmin(Request $request, AdministrationRepository $repository, \App\Service\Dismiss $dismiss): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $limit = $dataform["number"];

            if($_GET['type'] === "Salary"){
                $dismiss->salary($repository, $limit);
                return $this->redirectToRoute('player_human_ressourcies');
            }

            if($_GET['type'] == "People") {
                $dismiss->people($repository, $limit);

                return $this->redirectToRoute('player_human_ressourcies');
            }
        }

        return $this->render('dismiss/dismiss.html.twig', [
            'form' => $form->createView(),
            'people' => 'administrative'
        ]);

    }

    /**
     * @Route("/dismissresearcher", name="researcher_dismiss", methods={"GET","POST"})
     * @param Request $request
     * @param ResearcherRepository $repository
     * @param \App\Service\Dismiss $dismiss
     * @return Response
     */
    public function dismissResearcher(Request $request, ResearcherRepository $repository, \App\Service\Dismiss $dismiss): Response
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

        return $this->render('dismiss/dismiss.html.twig', [
            'form' => $form->createView(),
            'people' => 'research people'
        ]);

    }

    /**
     * @Route("/dismissprod", name="production_dismiss", methods={"GET","POST"})
     * @param Request $request
     * @param ProductionRepository $repository
     * @param \App\Service\Dismiss $dismiss
     * @return Response
     */
    public function dismissProd(Request $request, ProductionRepository $repository, \App\Service\Dismiss $dismiss): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $limit = $dataform["number"];

            if($_GET['type'] === "Salary"){
                $dismiss->salary($repository, $limit);
                return $this->redirectToRoute('player_human_ressourcies');
            }

            if($_GET['type'] == "People") {
                $dismiss->people($repository, $limit);

                return $this->redirectToRoute('player_human_ressourcies');
            }
        }

        return $this->render('dismiss/dismiss.html.twig', [
            'form' => $form->createView(),
            'people' => 'productive people'
        ]);

    }

    /**
     * @Route("/dismisssales", name="salesman_dismiss", methods={"GET","POST"})
     * @param Request $request
     * @param SalesManRepository $repository
     * @param \App\Service\Dismiss $dismiss
     * @return Response
     */
    public function dismissSales(Request $request, SalesManRepository $repository, \App\Service\Dismiss $dismiss): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $limit = $dataform["number"];

            if($_GET['type'] === "Salary"){
                $dismiss->salary($repository, $limit);
                return $this->redirectToRoute('player_human_ressourcies');
            }

            if($_GET['type'] == "People") {
                $dismiss->people($repository, $limit);

                return $this->redirectToRoute('player_human_ressourcies');
            }
        }

        return $this->render('dismiss/dismiss.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);

    }

    /**
     * @Route("/dismiss", name="salesman_dismiss", methods={"GET","POST"})
     * @param Request $request
     * @param HumanRessourceRepository $repository
     * @param \App\Service\Dismiss $dismiss
     * @return Response
     */
    public function dismissAll(Request $request, HumanRessourceRepository $repository, \App\Service\Dismiss $dismiss): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $limit = $dataform["number"];

            if($_GET['type'] === "Salary"){
                $dismiss->salary($repository, $limit);
                return $this->redirectToRoute('player_human_ressourcies');
            }

            if($_GET['type'] == "People") {
                $dismiss->people($repository, $limit);

                return $this->redirectToRoute('player_human_ressourcies');
            }
        }

        return $this->render('dismiss/dismiss.html.twig', [
            'form' => $form->createView(),
            'people' => 'sales forces'
        ]);

    }


}
