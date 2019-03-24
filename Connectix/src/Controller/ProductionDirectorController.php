<?php

namespace App\Controller;

use App\Entity\ProductionDirector;
use App\Form\ProductionDirectorType;
use App\Repository\ProductionDirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productiondirector")
 */
class ProductionDirectorController extends AbstractController
{
    /**
     * @Route("/", name="production_director_index", methods={"GET"})
     */
    public function index(ProductionDirectorRepository $productionDirectorRepository): Response
    {
        return $this->render('production_director/index.html.twig', [
            'production_directors' => $productionDirectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="production_director_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productionDirector = new ProductionDirector();
        $form = $this->createForm(ProductionDirectorType::class, $productionDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productionDirector);
            $entityManager->flush();

            return $this->redirectToRoute('production_director_index');
        }

        return $this->render('production_director/new.html.twig', [
            'production_director' => $productionDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_director_show", methods={"GET"})
     */
    public function show(ProductionDirector $productionDirector): Response
    {
        return $this->render('production_director/show.html.twig', [
            'production_director' => $productionDirector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="production_director_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductionDirector $productionDirector): Response
    {
        $form = $this->createForm(ProductionDirectorType::class, $productionDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('production_director_index', [
                'id' => $productionDirector->getId(),
            ]);
        }

        return $this->render('production_director/edit.html.twig', [
            'production_director' => $productionDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="production_director_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductionDirector $productionDirector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productionDirector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productionDirector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('production_director_index');
    }
}
