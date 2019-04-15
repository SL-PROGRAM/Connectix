<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\PurchaseOrder;
use App\Form\PurchaseOrderType;
use App\Repository\ProductRepository;
use App\Repository\PurchaseOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/purchaseorder")
 */
class PurchaseOrderController extends AbstractController
{

    /**
     * @Route("/new", name="purchase_order_new", methods={"GET","POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $purchaseOrder = new PurchaseOrder();
        $form = $this->createForm(PurchaseOrderType::class, $purchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $purchaseOrder->setStatus(0);

            $turn = $this->getUser()->getGame()->getTurn();
            $purchaseOrder->setTurn($turn);

            $socity = $this->getUser()->getSocity();
            $purchaseOrder->setSocity($socity);

            $product = $productRepository->findOneBy(["id" => $_GET["id"]]);
            $purchaseOrder->setProduct($product);

            $productActivityCost = 10; // $purchaseOrder->getProduct()->getProductionActivityCost();
            $quantity = $purchaseOrder->getProductQuantityPurchase();

            $productionActivityCost = $quantity*$productActivityCost;
            $purchaseOrder->setPurchaseActivityCost($productionActivityCost);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($purchaseOrder);
            $entityManager->flush();

            return $this->redirectToRoute('player_sales');
        }

        return $this->render('purchase_order/new.html.twig', [
            'purchase_order' => $purchaseOrder,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="purchase_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        $form = $this->createForm(PurchaseOrderType::class, $purchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_sales', [
                'id' => $purchaseOrder->getId(),
            ]);
        }

        return $this->render('purchase_order/edit.html.twig', [
            'purchase_order' => $purchaseOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchaseOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchaseOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_sales');
    }
}
