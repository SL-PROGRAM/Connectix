<?php

namespace App\Controller;

use App\Entity\Administration;
use App\Form\AdministrationType;
use App\Repository\AdministrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration")
 */
class AdministrationController extends AbstractController
{
    /**
     * @Route("/", name="administration_index", methods={"GET"})
     */
    public function index(AdministrationRepository $administrationRepository): Response
    {
        return $this->render('administration/index.html.twig', [
            'administrations' => $administrationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="administration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $administration = new Administration();
        $form = $this->createForm(AdministrationType::class, $administration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($administration);
            $entityManager->flush();

            return $this->redirectToRoute('administration_index');
        }

        return $this->render('administration/new.html.twig', [
            'administration' => $administration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administration_show", methods={"GET"})
     */
    public function show(Administration $administration): Response
    {
        return $this->render('administration/show.html.twig', [
            'administration' => $administration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="administration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Administration $administration): Response
    {
        $form = $this->createForm(AdministrationType::class, $administration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administration_index', [
                'id' => $administration->getId(),
            ]);
        }

        return $this->render('administration/edit.html.twig', [
            'administration' => $administration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administration_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Administration $administration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($administration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('administration_index');
    }
}
