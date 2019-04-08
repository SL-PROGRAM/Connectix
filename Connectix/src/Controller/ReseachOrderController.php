<?php

namespace App\Controller;

use App\Entity\ReseachOrder;
use App\Form\ReseachOrderType;
use App\Repository\ReseachOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/reseachorder")
 * @ISGranted("ROLE_USER")
 */
class ReseachOrderController extends AbstractController
{
    /**
     * @Route("/", name="reseach_order_index", methods={"GET"})
     */
    public function index(ReseachOrderRepository $reseachOrderRepository): Response
    {
        return $this->render('reseach_order/index.html.twig', [
            'reseach_orders' => $reseachOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reseach_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reseachOrder = new ReseachOrder();
        $form = $this->createForm(ReseachOrderType::class, $reseachOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn = $this->getUser()->getGame()->getTurn();
            $reseachOrder->setTurn($turn);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reseachOrder);
            $entityManager->flush();

            return $this->redirectToRoute('reseach_order_index');
        }

        return $this->render('reseach_order/new.html.twig', [
            'reseach_order' => $reseachOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reseach_order_show", methods={"GET"})
     */
    public function show(ReseachOrder $reseachOrder): Response
    {
        return $this->render('reseach_order/show.html.twig', [
            'reseach_order' => $reseachOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reseach_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReseachOrder $reseachOrder): Response
    {
        $form = $this->createForm(ReseachOrderType::class, $reseachOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reseach_order_index', [
                'id' => $reseachOrder->getId(),
            ]);
        }

        return $this->render('reseach_order/edit.html.twig', [
            'reseach_order' => $reseachOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reseach_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReseachOrder $reseachOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reseachOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reseachOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reseach_order_index');
    }
}
