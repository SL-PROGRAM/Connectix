<?php

namespace App\Controller;

use App\Entity\PublicityOrder;
use App\Form\PublicityOrderType;
use App\Repository\ProductRepository;
use App\Repository\PublicityOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicityorder")
 * Class PublicityOrderController
 * @package App\Controller
 */
class PublicityOrderController extends AbstractController
{
    /**
     * @Route("/", name="publicity_order_index", methods={"GET"})
     * @param PublicityOrderRepository $publicityOrderRepository
     * @return Response
     */
    public function index(PublicityOrderRepository $publicityOrderRepository): Response
    {
        $socity = $this->getUser()->getSocity();
        return $this->render('publicity_order/index.html.twig', [
            'publicity_orders' => $publicityOrderRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="publicity_order_new", methods={"GET","POST"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $publicityOrder = new PublicityOrder();
        $form = $this->createForm(PublicityOrderType::class, $publicityOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn = $this->getUser()->getGame()->getTurn();
            $socity = $this->getUser()->getSocity();
            $product = $productRepository->findOneBy(["id" => $_GET["id"]]);

            $publicityOrder ->setTurn($turn)
                            ->setSocity($socity)
                            ->setProduct($product);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicityOrder);
            $entityManager->flush();

            return $this->redirectToRoute('player_publicity');
        }

        return $this->render('publicity_order/new.html.twig', [
            'publicity_order' => $publicityOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicity_order_show", methods={"GET"})
     * @param PublicityOrder $publicityOrder
     * @return Response
     */
    public function show(PublicityOrder $publicityOrder): Response
    {
        return $this->render('publicity_order/show.html.twig', [
            'publicity_order' => $publicityOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publicity_order_edit", methods={"GET","POST"})
     * @param Request $request
     * @param PublicityOrder $publicityOrder
     * @return Response
     */
    public function edit(Request $request, PublicityOrder $publicityOrder): Response
    {
        $form = $this->createForm(PublicityOrderType::class, $publicityOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_publicity', [
                'id' => $publicityOrder->getId(),
            ]);
        }

        return $this->render('publicity_order/edit.html.twig', [
            'publicity_order' => $publicityOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicity_order_delete", methods={"DELETE"})
     * @param Request $request
     * @param PublicityOrder $publicityOrder
     * @return Response
     */
    public function delete(Request $request, PublicityOrder $publicityOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicityOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicityOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_publicity');
    }
}
