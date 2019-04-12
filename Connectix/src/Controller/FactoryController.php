<?php

namespace App\Controller;

use App\Entity\Factory;
use App\Form\FactoryType;
use App\Repository\FactoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/factory")
 * @ISGranted("ROLE_USER")
 */
class FactoryController extends AbstractController
{

    /**
     * @Route("/new", name="factory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $factory = new Factory();
        $form = $this->createForm(FactoryType::class, $factory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socity = $this->getUser()->getSocity();
            $turn = $this->getUser()->getGame()->getTurn();
            $creationCost = $this->getUser()->getGame()->getFactoryCreationCost();
            $maintenanceCost = $this->getUser()->getGame()->getFactoryMaintenanceCost();
            $administrationCost = $this->getUser()->getGame()->getFactoryAdministrationCost();
            $amortizationTurn = $this->getUser()->getGame()->getFactoryAmortizationTurn();

            $factory->setAdministrationCost($administrationCost)
                ->setAmortizationTurn($amortizationTurn)
                ->setCreationCost($creationCost)
                ->setTurnCreation($turn)
                ->setSocity($socity)
                ->setMaintenanceCost($maintenanceCost);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($factory);
            $entityManager->flush();

            return $this->redirectToRoute('player_production');
        }

        return $this->render('factory/new.html.twig', [
            'factory' => $factory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="factory_show", methods={"GET"})
     */
    public function show(Factory $factory): Response
    {
        return $this->render('factory/show.html.twig', [
            'factory' => $factory,
        ]);
    }


    /**
     * @Route("/{id}", name="factory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Factory $factory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($factory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_production');
    }
}
