<?php

namespace App\Controller\Admin;

use App\Entity\BalanceSheet;
use App\Entity\Game;
use App\Entity\Loan;
use App\Entity\Socity;
use App\Entity\User;
use App\Form\SocityType;
use App\Repository\GameRepository;
use App\Service\MakeBalanceSheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/socity")
 */
class SocityController extends AbstractController
{




    /**
     * @Route("/new/{gameid}", name="socity_new", methods={"GET","POST"})
     */
    public function new($gameid, Request $request, GameRepository $gameRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $game = $gameRepository->findOneBy(['id' => $gameid]);
        $socity = new Socity();
        $form = $this->createForm(SocityType::class, $socity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $socity->setGame($game);

            $socity->setPriceMinPublicicyImpact(1);
            $socity->setPriceMaxPublicityImpact(1);

            $users = $socity->getUsers();
            foreach ($users as $user){
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $user->getPassword()
                    )
                );
                $user->setGame($game);
                $user->setSocity($socity);
                $entityManager->persist($user);
            }

            $entityManager->persist($socity);

            $loan = $this->makeStartLoan($game, $socity);
            $balanceSheet = $this->makeBalanceSheet($game, $socity);

            $entityManager->persist($loan);
            $entityManager->persist($balanceSheet);

            $entityManager->flush();

            if ($form->get('submitAndRestart')->isClicked()) {
                return $this->render('socity/new.html.twig', [
                    'socity' => $socity,
                    'form' => $form->createView(),
                ]);
            }

            if ($this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('home');
            }
            return $this->redirectToRoute('player_sales');

        }

        return $this->render('socity/new.html.twig', [
            'socity' => $socity,
            'form' => $form->createView(),
        ]);
    }

    private function makeStartLoan(Game $game, Socity $socity){
        $loan =new Loan();
        $borrowAmount = $game->getSocityStartLoanAmount();
        $loanInterestRate = $game->getSocityStartLoanInterestRate();
        $loanDuration = $game->getSocityStartLoanDuration();
        $loan->setSocity($socity)
            ->setTurn($game->getTurn())
            ->setBorrowAmount($borrowAmount)
            ->setBankInterest($loanInterestRate)
            ->setLoanDuration($loanDuration)
            ->setMonthlyDueDate(
                $borrowAmount/$loanDuration*(1+($loanInterestRate/100)^$loanDuration))
            ->setDelayLoanRepayment(0);

        return $loan;
    }

    private function makeBalanceSheet(Game $game, Socity $socity){
        $balanceSheet = new BalanceSheet();
        $balanceSheet->setShareCapitalOrIndividual($game->getSocityStartShareCapital())
            ->setSocity($socity)
            ->setTurn($game->getTurn())
        ;

        return $balanceSheet;
    }
}
