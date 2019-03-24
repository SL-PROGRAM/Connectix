<?php

namespace App\Controller;

use App\Entity\ResearcherDirector;
use App\Form\ResearcherDirectorType;
use App\Repository\ResearcherDirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/researcherdirector")
 */
class ResearcherDirectorController extends AbstractController
{
    /**
     * @Route("/", name="researcher_director_index", methods={"GET"})
     */
    public function index(ResearcherDirectorRepository $researcherDirectorRepository): Response
    {
        return $this->render('researcher_director/index.html.twig', [
            'researcher_directors' => $researcherDirectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="researcher_director_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $researcherDirector = new ResearcherDirector();
        $form = $this->createForm(ResearcherDirectorType::class, $researcherDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($researcherDirector);
            $entityManager->flush();

            return $this->redirectToRoute('researcher_director_index');
        }

        return $this->render('researcher_director/new.html.twig', [
            'researcher_director' => $researcherDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="researcher_director_show", methods={"GET"})
     */
    public function show(ResearcherDirector $researcherDirector): Response
    {
        return $this->render('researcher_director/show.html.twig', [
            'researcher_director' => $researcherDirector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="researcher_director_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ResearcherDirector $researcherDirector): Response
    {
        $form = $this->createForm(ResearcherDirectorType::class, $researcherDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('researcher_director_index', [
                'id' => $researcherDirector->getId(),
            ]);
        }

        return $this->render('researcher_director/edit.html.twig', [
            'researcher_director' => $researcherDirector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="researcher_director_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ResearcherDirector $researcherDirector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$researcherDirector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($researcherDirector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('researcher_director_index');
    }
}
