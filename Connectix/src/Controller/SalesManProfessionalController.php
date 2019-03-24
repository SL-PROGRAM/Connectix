<?php

namespace App\Controller;

use App\Entity\SalesManProfessional;
use App\Form\SalesManProfessionalType;
use App\Repository\SalesManProfessionalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmanprofessional")
 */
class SalesManProfessionalController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_professional_index", methods={"GET"})
     */
    public function index(SalesManProfessionalRepository $salesManProfessionalRepository): Response
    {
        return $this->render('sales_man_professional/index.html.twig', [
            'sales_man_professionals' => $salesManProfessionalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_professional_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $salesManProfessional = new SalesManProfessional();
        $form = $this->createForm(SalesManProfessionalType::class, $salesManProfessional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salesManProfessional);
            $entityManager->flush();

            return $this->redirectToRoute('sales_man_professional_index');
        }

        return $this->render('sales_man_professional/new.html.twig', [
            'sales_man_professional' => $salesManProfessional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_professional_show", methods={"GET"})
     */
    public function show(SalesManProfessional $salesManProfessional): Response
    {
        return $this->render('sales_man_professional/show.html.twig', [
            'sales_man_professional' => $salesManProfessional,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sales_man_professional_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SalesManProfessional $salesManProfessional): Response
    {
        $form = $this->createForm(SalesManProfessionalType::class, $salesManProfessional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_man_professional_index', [
                'id' => $salesManProfessional->getId(),
            ]);
        }

        return $this->render('sales_man_professional/edit.html.twig', [
            'sales_man_professional' => $salesManProfessional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_professional_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SalesManProfessional $salesManProfessional): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salesManProfessional->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salesManProfessional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sales_man_professional_index');
    }
}
