<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Form\TechnicianType;
use App\Repository\TechnicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/technician")
 */
class TechnicianController extends AbstractController
{
    /**
     * @Route("/", name="technician_index", methods={"GET"})
     */
    public function index(TechnicianRepository $technicianRepository): Response
    {
        return $this->render('technician/index.html.twig', [
            'technicians' => $technicianRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="technician_new", methods={"NEW"})
     */
    public function new(Request $request): Response
    {
        $technician = new Technician();
        $coeficientSalary = 1.8;
        $formation = 75;
        $experience = 0;
        $productivity = $formation+$experience;
        $salary = $this->getUser()->getGame()->getSmic() * $coeficientSalary;
        $socity = $this->getUser()->getSocity();
        $productionActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.9;
        $administrationActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100*0.1;
        $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

        $technician
            ->setAdministrationActivity($administrationActivity)
            ->setProductionActivity($productionActivity)
            ->setAdministrationActivityCost($administrationActivityCost)
            ->setSocity($socity)
            ->setCoeficientSalary($coeficientSalary)
            ->setExprience($experience)
            ->setFormation($formation)
            ->setProductivity($productivity)
            ->setSalary($salary)
        ;


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($technician);
        $entityManager->flush();

        return $this->redirectToRoute('player_human_ressourcies');
    }

    /**
     * @Route("/{id}", name="technician_show", methods={"GET"})
     */
    public function show(Technician $technician): Response
    {
        return $this->render('technician/show.html.twig', [
            'technician' => $technician,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="technician_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Technician $technician): Response
    {
        $form = $this->createForm(TechnicianType::class, $technician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technician_index', [
                'id' => $technician->getId(),
            ]);
        }

        return $this->render('technician/edit.html.twig', [
            'technician' => $technician,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technician_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Technician $technician): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technician->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($technician);
            $entityManager->flush();
        }

        return $this->redirectToRoute('technician_index');
    }
}
