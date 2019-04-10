<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanFactoryType;
use App\Form\LoanProductionLignType;
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
        $turn = $this->getUser()->getGame()->getTurn();

        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
            'turn' => $turn,

        ]);
    }

    /**
     * @Route("/factory", name="loan_factory", methods={"GET","POST"})
     */
    public function newLoanFactory(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanFactoryType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanDuration = $this->getUser()->getGame()->getFactoryAmortizationTurn();
            $DelayLoanRepayment = 0;
            $bankInterest = $this->getUser()->getGame()->getSocityStartLoanInterestRate();
            $turn = $this->getUser()->getGame()->getTurn();
            $socity = $this->getUser()->getSocity();
            $dueDate = $loan->getBorrowAmount()/$loanDuration;



            $loan   ->setSocity($socity)
                ->setBankInterest($bankInterest)
                ->setLoanDuration($loanDuration)
                ->setTurn($turn)
                ->setDelayLoanRepayment($DelayLoanRepayment)
                ->setMonthlyDueDate($dueDate/12);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('player_financial');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/productionlign", name="loan_production_lign", methods={"GET","POST"})
     */
    public function newLoanProductionLign(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanProductionLignType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanDuration = $this->getUser()->getGame()->getProductionLignAmortizationTurn();
            $DelayLoanRepayment = 0;
            $bankInterest = $this->getUser()->getGame()->getSocityStartLoanInterestRate();
            $turn = $this->getUser()->getGame()->getTurn();
            $socity = $this->getUser()->getSocity();
            $dueDate = $loan->getBorrowAmount()/$loanDuration;



            $loan   ->setSocity($socity)
                ->setBankInterest($bankInterest)
                ->setLoanDuration($loanDuration)
                ->setTurn($turn)
                ->setDelayLoanRepayment($DelayLoanRepayment)
                ->setMonthlyDueDate($dueDate/12);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('player_financial');
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
    public function editLoanFactory(Request $request, Loan $loan): Response
    {
        $form = $this->createForm(LoanFactoryType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanDuration = $loan->getLoanDuration();
            $dueDate = $loan->getBorrowAmount()/$loanDuration;

            $loan->setMonthlyDueDate($dueDate/12);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_financial', [
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

        return $this->redirectToRoute('player_financial');
    }
}
