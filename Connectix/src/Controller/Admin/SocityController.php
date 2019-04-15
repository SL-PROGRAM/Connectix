<?php

namespace App\Controller\Admin;

use App\Entity\Socity;
use App\Form\Socity1Type;
use App\Repository\SocityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/socity")
 */
class SocityController extends AbstractController
{
    /**
     * @Route("/", name="socity_index", methods={"GET"})
     */
    public function index(SocityRepository $socityRepository): Response
    {
        return $this->render('socity/index.html.twig', [
            'socities' => $socityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="socity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $socity = new Socity();
        $form = $this->createForm(Socity1Type::class, $socity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($socity);
            $entityManager->flush();

            return $this->redirectToRoute('socity_index');
        }

        return $this->render('socity/new.html.twig', [
            'socity' => $socity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="socity_show", methods={"GET"})
     */
    public function show(Socity $socity): Response
    {
        return $this->render('socity/show.html.twig', [
            'socity' => $socity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="socity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Socity $socity): Response
    {
        $form = $this->createForm(Socity1Type::class, $socity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('socity_index', [
                'id' => $socity->getId(),
            ]);
        }

        return $this->render('socity/edit.html.twig', [
            'socity' => $socity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="socity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Socity $socity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($socity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('socity_index');
    }
}
