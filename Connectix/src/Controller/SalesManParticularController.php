<?php

namespace App\Controller;

use App\Entity\SalesManParticular;
use App\Form\SalesManParticularType;
use App\Repository\SalesManParticularRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmanparticular")
 */
class SalesManParticularController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_particular_index", methods={"GET"})
     */
    public function index(SalesManParticularRepository $salesManParticularRepository): Response
    {
        return $this->render('sales_man_particular/index.html.twig', [
            'sales_man_particulars' => $salesManParticularRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_particular_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $salesManParticular = new SalesManParticular();
        $form = $this->createForm(SalesManParticularType::class, $salesManParticular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salesManParticular);
            $entityManager->flush();

            return $this->redirectToRoute('sales_man_particular_index');
        }

        return $this->render('sales_man_particular/new.html.twig', [
            'sales_man_particular' => $salesManParticular,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_particular_show", methods={"GET"})
     */
    public function show(SalesManParticular $salesManParticular): Response
    {
        return $this->render('sales_man_particular/show.html.twig', [
            'sales_man_particular' => $salesManParticular,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sales_man_particular_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SalesManParticular $salesManParticular): Response
    {
        $form = $this->createForm(SalesManParticularType::class, $salesManParticular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_man_particular_index', [
                'id' => $salesManParticular->getId(),
            ]);
        }

        return $this->render('sales_man_particular/edit.html.twig', [
            'sales_man_particular' => $salesManParticular,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_particular_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SalesManParticular $salesManParticular): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salesManParticular->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salesManParticular);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sales_man_particular_index');
    }
}
