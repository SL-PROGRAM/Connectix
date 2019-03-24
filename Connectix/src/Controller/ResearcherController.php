<?php

namespace App\Controller;

use App\Entity\Researcher;
use App\Form\ResearcherType;
use App\Repository\ReseacherRepository;
use App\Repository\ResearcherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/researcher")
 */
class ResearcherController extends AbstractController
{
    /**
     * @Route("/", name="researcher_index", methods={"GET"})
     */
    public function index(ResearcherRepository $reseacherRepository): Response
    {
        return $this->render('researcher/index.html.twig', [
            'researchers' => $reseacherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="researcher_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $researcher = new Researcher();
        $form = $this->createForm(ResearcherType::class, $researcher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($researcher);
            $entityManager->flush();

            return $this->redirectToRoute('researcher_index');
        }

        return $this->render('researcher/new.html.twig', [
            'researcher' => $researcher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="researcher_show", methods={"GET"})
     */
    public function show(Researcher $researcher): Response
    {
        return $this->render('researcher/show.html.twig', [
            'researcher' => $researcher,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="researcher_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Researcher $researcher): Response
    {
        $form = $this->createForm(ResearcherType::class, $researcher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('researcher_index', [
                'id' => $researcher->getId(),
            ]);
        }

        return $this->render('researcher/edit.html.twig', [
            'researcher' => $researcher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="researcher_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Researcher $researcher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$researcher->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($researcher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('researcher_index');
    }
}
