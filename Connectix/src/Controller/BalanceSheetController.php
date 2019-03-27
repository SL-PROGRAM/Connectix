<?php

namespace App\Controller;

use App\Entity\BalanceSheet;
use App\Form\BalanceSheetType;
use App\Repository\BalanceSheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/balancesheet")
 */
class BalanceSheetController extends AbstractController
{
    /**
     * @Route("/", name="balance_sheet_index", methods={"GET"})
     */
    public function index(BalanceSheetRepository $balanceSheetRepository): Response
    {
        return $this->render('balance_sheet/index.html.twig', [
            'balance_sheets' => $balanceSheetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="balance_sheet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $balanceSheet = new BalanceSheet();
        $form = $this->createForm(BalanceSheetType::class, $balanceSheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($balanceSheet);
            $entityManager->flush();

            return $this->redirectToRoute('balance_sheet_index');
        }

        return $this->render('balance_sheet/new.html.twig', [
            'balance_sheet' => $balanceSheet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="balance_sheet_show", methods={"GET"})
     */
    public function show(BalanceSheet $balanceSheet): Response
    {
        return $this->render('balance_sheet/show.html.twig', [
            'balance_sheet' => $balanceSheet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="balance_sheet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BalanceSheet $balanceSheet): Response
    {
        $form = $this->createForm(BalanceSheetType::class, $balanceSheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('balance_sheet_index', [
                'id' => $balanceSheet->getId(),
            ]);
        }

        return $this->render('balance_sheet/edit.html.twig', [
            'balance_sheet' => $balanceSheet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="balance_sheet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BalanceSheet $balanceSheet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$balanceSheet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($balanceSheet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('balance_sheet_index');
    }
}
