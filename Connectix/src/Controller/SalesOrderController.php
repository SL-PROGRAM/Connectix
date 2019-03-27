<?php

namespace App\Controller;

use App\Entity\SalesOrder;
use App\Form\SalesOrderType;
use App\Repository\ProductRepository;
use App\Repository\SalesOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesorder")
 */
class SalesOrderController extends AbstractController
{
    /**
     * @Route("/", name="sales_order_index", methods={"GET"})
     */
    public function index(SalesOrderRepository $salesOrderRepository): Response
    {
        return $this->render('sales_order/index.html.twig', [
            'sales_orders' => $salesOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_order_new", methods={"GET","POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $salesOrder = new SalesOrder();
        $form = $this->createForm(SalesOrderType::class, $salesOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn = $this->getUser()->getGame()->getTurn();
            $salesActivityCost = 10*$salesOrder->getProductQuantitySales();
            $socity = $this->getUser()->getSocity();
            $product = $productRepository->findOneBy(["id" => $_GET["id"]]);


            $salesOrder->setTurn($turn)
                        ->setStatus(0)
                        ->setSalesActivityCost($salesActivityCost)
                        ->setSocity($socity)
                        ->setProduct($product);




            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salesOrder);
            $entityManager->flush();

            return $this->redirectToRoute('sales_order_index');
        }

        return $this->render('sales_order/new.html.twig', [
            'sales_order' => $salesOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_order_show", methods={"GET"})
     */
    public function show(SalesOrder $salesOrder): Response
    {
        return $this->render('sales_order/show.html.twig', [
            'sales_order' => $salesOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sales_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SalesOrder $salesOrder): Response
    {
        $form = $this->createForm(SalesOrderType::class, $salesOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_order_index', [
                'id' => $salesOrder->getId(),
            ]);
        }

        return $this->render('sales_order/edit.html.twig', [
            'sales_order' => $salesOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SalesOrder $salesOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salesOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salesOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sales_order_index');
    }
}
