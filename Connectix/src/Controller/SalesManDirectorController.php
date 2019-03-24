<?php

namespace App\Controller;

use App\Entity\SalesManDirector;
use App\Form\SalesManDirectorType;
use App\Repository\SalesManDirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salesmandirector")
 */
class SalesManDirectorController extends AbstractController
{
    /**
     * @Route("/", name="sales_man_director_index", methods={"GET"})
     */
    public function index(SalesManDirectorRepository $salesManDirectorRepository): Response
    {
        return $this->render('sales_man_director/index.html.twig', [
            'sales_man_directors' => $salesManDirectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_man_director_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $salesManDirector = new SalesManDirector();
        $form = $this->createForm(SalesManDirectorType::class, $salesManDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salesManDirector);
            $entityManager->flush();

            return $this->redirectToRoute('sales_man_director_index');
        }

        return $this->render('sales_man_director/new.html.twig', [
            'sales_man_director' => $salesManDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_director_show", methods={"GET"})
     */
    public function show(SalesManDirector $salesManDirector): Response
    {
        return $this->render('sales_man_director/show.html.twig', [
            'sales_man_director' => $salesManDirector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sales_man_director_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SalesManDirector $salesManDirector): Response
    {
        $form = $this->createForm(SalesManDirectorType::class, $salesManDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_man_director_index', [
                'id' => $salesManDirector->getId(),
            ]);
        }

        return $this->render('sales_man_director/edit.html.twig', [
            'sales_man_director' => $salesManDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_man_director_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SalesManDirector $salesManDirector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salesManDirector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salesManDirector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sales_man_director_index');
    }
}
