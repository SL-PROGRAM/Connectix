<?php

namespace App\Controller\Admin;

use App\Entity\Socity;
use App\Form\SocityType;
use App\Repository\GameRepository;
use App\Service\MakeBalanceSheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/socity")
 */
class SocityController extends AbstractController
{


    /**
     * @var EncoderFactoryInterface
     */
    private $securityEncoderFactory;

    public function __construct(EncoderFactoryInterface $securityEncoderFactory)
    {
        $this->securityEncoderFactory = $securityEncoderFactory;
    }


    /**
     * @Route("/new/{gameid}", name="socity_new", methods={"GET","POST"})
     */
    public function new($gameid, Request $request, GameRepository $gameRepository, MakeBalanceSheet $makeBalanceSheet, UserPasswordEncoderInterface $passwordEncoder): Response
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
            $entityManager->flush();

            $makeBalanceSheet->makeBalanceSheet($socity, $game);

            return $this->redirectToRoute('socity_new');
        }

        return $this->render('socity/new.html.twig', [
            'socity' => $socity,
            'form' => $form->createView(),
        ]);
    }

}
