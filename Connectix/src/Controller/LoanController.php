<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanByDueDateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoanController extends AbstractController
{
    /**
     * @Route("/loan", name="loan")
     */
    public function index()
    {
        return $this->render('loan/index.html.twig', [
            'controller_name' => 'LoanController',
        ]);
    }

    /**
     * @Route("/new/duedate", name="socity_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('loan');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/duration", name="socity_new", methods={"GET","POST"})
     */
    public function newLoanByDuration(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanByDueDateType::class, $loan);
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

            return $this->redirectToRoute('loan');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

}
