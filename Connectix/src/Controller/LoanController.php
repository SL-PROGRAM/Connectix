<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanByDueDateType;
use App\Form\LoanByDurationType;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newduedate", name="loan_new_duedate", methods={"GET","POST"})
     */
    public function newLoanByDueDate(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanByDueDateType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO add calculation of loanDuration
            $loanDuration = 0;
            //TODO add get to bankInterest
            $bankInterest = 0;

            $socity = $this->getUser()->getSocity();


            $loan   ->setSocity($socity)
                ->setBankInterest($bankInterest)
                ->setLoanDuration($loanDuration);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }


//    /**
//     * @Route("/new", name="loan_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $loan = new Loan();
//        $form = $this->createForm(LoanType::class, $loan);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($loan);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('loan_index');
//        }
//
//        return $this->render('loan/new.html.twig', [
//            'loan' => $loan,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/newduration", name="loan_new_duration", methods={"GET","POST"})
     */
    public function newLoanByDuration(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanByDurationType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO add calculation of loanDueDate
            $loanDueDate = 0;
            //TODO add get to bankInterest
            $bankInterest = 0;

            $socity = $this->getUser()->getSocity();


            $loan   ->setSocity($socity)
                ->setBankInterest($bankInterest)
                ->setMonthlyDueDate($loanDueDate);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_show", methods={"GET"})
     */
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="loan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loan $loan): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loan_index', [
                'id' => $loan->getId(),
            ]);
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Loan $loan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loan_index');
    }
}
