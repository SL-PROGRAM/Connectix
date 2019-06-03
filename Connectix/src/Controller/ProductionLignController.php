<?php

namespace App\Controller;

use App\Entity\ProductionLign;
use App\Form\ProductionLignType;
use App\Repository\FactoryRepository;
use App\Repository\ProductionLignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productionlign")
 * Class ProductionLignController
 * @package App\Controller
 */
class ProductionLignController extends AbstractController
{
    /**
     * @Route("/", name="production_lign_index", methods={"GET"})
     * @param ProductionLignRepository $productionLignRepository
     * @return Response
     */
    public function index(ProductionLignRepository $productionLignRepository): Response
    {
        $socity = $this->getUser()->getSocity();

        return $this->render('production_lign/index.html.twig', [
            'production_ligns' => $productionLignRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="production_lign_new", methods={"GET","POST"})
     * @param Request $request
     * @param FactoryRepository $factoryRepository
     * @return Response
     */
    public function new(Request $request, FactoryRepository $factoryRepository): Response
    {
        $productionLign = new ProductionLign();
        $form = $this->createForm(ProductionLignType::class, $productionLign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socity = $this->getUser()->getSocity();
            $turn = $this->getUser()->getGame()->getTurn();
            $creationCost = $this->getUser()->getGame()->getProductionLignCreationCost();
            $maintenanceCost = $this->getUser()->getGame()->getProductionLignMaintenanceCost();
            $administrationCost = $this->getUser()->getGame()->getProductionLignAdministrationCost();
            $amortizationTurn = $this->getUser()->getGame()->getProductionLignAmortizationTurn();
            $annualProductTime = $this->getUser()->getGame()->getProductionLignAnnualProductTime();
            $totalLifeProductTime = $this->getUser()->getGame()->getProductionLignTotalLifeProductTime();
            $factory = $factoryRepository->findOneBy(["id" => $_GET["id"]]);


            $productionLign
                ->setAnnualProductTime($annualProductTime)
                ->setFactory($factory)
                ->setTotalLifeProductTime($totalLifeProductTime)
                ->setAdministrationCost($administrationCost)
                ->setAmortizationTurn($amortizationTurn)
                ->setCreationCost($creationCost)
                ->setTurnCreation($turn)
                ->setSocity($socity)
                ->setMaintenanceCost($maintenanceCost)
            ;


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productionLign);
            $entityManager->flush();

            return $this->redirectToRoute('player_production');
        }

        return $this->render('production_lign/new.html.twig', [
            'production_lign' => $productionLign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_lign_show", methods={"GET"})
     * @param ProductionLign $productionLign
     * @return Response
     */
    public function show(ProductionLign $productionLign): Response
    {
        return $this->render('production_lign/show.html.twig', [
            'production_lign' => $productionLign,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="production_lign_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ProductionLign $productionLign
     * @return Response
     */
    public function edit(Request $request, ProductionLign $productionLign): Response
    {
        $form = $this->createForm(ProductionLignType::class, $productionLign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_production', [
                'id' => $productionLign->getId(),
            ]);
        }

        return $this->render('production_lign/edit.html.twig', [
            'production_lign' => $productionLign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_lign_delete", methods={"DELETE"})
     * @param Request $request
     * @param ProductionLign $productionLign
     * @return Response
     */
    public function delete(Request $request, ProductionLign $productionLign): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productionLign->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productionLign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_production');
    }
}
