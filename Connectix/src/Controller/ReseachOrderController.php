<?php

namespace App\Controller;

use App\Entity\ReseachOrder;
use App\Form\ReseachOrderType;
use App\Repository\ProductRepository;
use App\Repository\ReseachOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/reseachorder")
 * @ISGranted("ROLE_USER")
 * Class ReseachOrderController
 * @package App\Controller
 */
class ReseachOrderController extends AbstractController
{
    /**
     * @Route("/", name="reseach_order_index", methods={"GET"})
     * @param ReseachOrderRepository $reseachOrderRepository
     * @return Response
     */
    public function index(ReseachOrderRepository $reseachOrderRepository): Response
    {
        $socity = $this->getUser()->getSocity();

        return $this->render('reseach_order/index.html.twig', [
            'reseach_orders' => $reseachOrderRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="reseach_order_new", methods={"GET","POST"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $reseachOrder = new ReseachOrder();
        $form = $this->createForm(ReseachOrderType::class, $reseachOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn = $this->getUser()->getGame()->getTurn();
            $socity = $this->getUser()->getSocity();
            $product = $productRepository->findOneBy(["id" => $_GET["id"]]);
            $researchActivityCost = $reseachOrder->getReseachDo();
            $administrationActivityCost = $reseachOrder->getReseachDo()*0.5;



            $reseachOrder->setTurn($turn)
                        ->setSocity($socity)
                        ->setProduct($product)
                        ->setResearchActivityCost($researchActivityCost)
                        ->setAdministrationActivityCost($administrationActivityCost);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reseachOrder);
            $entityManager->flush();



            return $this->redirectToRoute('player_production');
        }

        return $this->render('reseach_order/new.html.twig', [
            'reseach_order' => $reseachOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reseach_order_show", methods={"GET"})
     * @param ReseachOrder $reseachOrder
     * @return Response
     */
    public function show(ReseachOrder $reseachOrder): Response
    {
        return $this->render('reseach_order/show.html.twig', [
            'reseach_order' => $reseachOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reseach_order_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ReseachOrder $reseachOrder
     * @return Response
     */
    public function edit(Request $request, ReseachOrder $reseachOrder): Response
    {
        $form = $this->createForm(ReseachOrderType::class, $reseachOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_production', [
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
     * @param Request $request
     * @param ReseachOrder $reseachOrder
     * @return Response
     */
    public function delete(Request $request, ReseachOrder $reseachOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reseachOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reseachOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_production');
    }
}
