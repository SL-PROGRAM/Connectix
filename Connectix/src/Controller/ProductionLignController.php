<?php

namespace App\Controller;

use App\Entity\ProductionLign;
use App\Form\ProductionLignType;
use App\Repository\ProductionLignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productionlign")
 */
class ProductionLignController extends AbstractController
{
    /**
     * @Route("/", name="production_lign_index", methods={"GET"})
     */
    public function index(ProductionLignRepository $productionLignRepository): Response
    {
        return $this->render('production_lign/index.html.twig', [
            'production_ligns' => $productionLignRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="production_lign_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productionLign = new ProductionLign();
        $form = $this->createForm(ProductionLignType::class, $productionLign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productionLign);
            $entityManager->flush();

            return $this->redirectToRoute('production_lign_index');
        }

        return $this->render('production_lign/new.html.twig', [
            'production_lign' => $productionLign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_lign_show", methods={"GET"})
     */
    public function show(ProductionLign $productionLign): Response
    {
        return $this->render('production_lign/show.html.twig', [
            'production_lign' => $productionLign,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="production_lign_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductionLign $productionLign): Response
    {
        $form = $this->createForm(ProductionLignType::class, $productionLign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('production_lign_index', [
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
     */
    public function delete(Request $request, ProductionLign $productionLign): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productionLign->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productionLign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('production_lign_index');
    }
}
