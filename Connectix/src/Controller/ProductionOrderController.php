<?php

namespace App\Controller;

use App\Entity\ProductionOrder;
use App\Form\ProductionOrderType;
use App\Repository\ProductionOrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/productionorder")
 * @ISGranted("ROLE_USER")
 */
class ProductionOrderController extends AbstractController
{
    /**
     * @Route("/", name="production_order_index", methods={"GET"})
     */
    public function index(ProductionOrderRepository $productionOrderRepository): Response
    {
        return $this->render('production_order/index.html.twig', [
            'production_orders' => $productionOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="production_order_new", methods={"GET","POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $productionOrder = new ProductionOrder();
        $form = $this->createForm(ProductionOrderType::class, $productionOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn = $this->getUser()->getGame()->getTurn();
            $socity = $this->getUser()->getSocity();
            $status = 0;
            $productionActivityCost = $productionOrder->getQuantityProductCreat()*2;
            $administrationActivityCost = $productionOrder->getQuantityProductCreat()*0.2;
            $product = $productRepository->findOneBy(['id' => $_GET["id"]]);
            $productionTime = $productionOrder->getQuantityProductCreat()*$product->getProductiorTimeCost();
            $rowMaterialCost = $productionOrder->getQuantityProductCreat()*$product->getRowMaterialCost();

            $productionOrder->setProduct($product)
                ->setTurn($turn)
                ->setStatus($status)
                ->setSocity($socity)
                ->setProductionActivityCost($productionActivityCost)
                ->setAdministrationActivityCost($administrationActivityCost)
                ->setProduct($product)
                ->setProductionTime($productionTime)
                ->setRowMaterialCost($rowMaterialCost);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productionOrder);
            $entityManager->flush();

            return $this->redirectToRoute('player_production');
        }

        return $this->render('production_order/new.html.twig', [
            'production_order' => $productionOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_order_show", methods={"GET"})
     */
    public function show(ProductionOrder $productionOrder): Response
    {
        return $this->render('production_order/show.html.twig', [
            'production_order' => $productionOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="production_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductionOrder $productionOrder): Response
    {
        $form = $this->createForm(ProductionOrderType::class, $productionOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_production', [
                'id' => $productionOrder->getId(),
            ]);
        }

        return $this->render('production_order/edit.html.twig', [
            'production_order' => $productionOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductionOrder $productionOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productionOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productionOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_production');
    }
}
