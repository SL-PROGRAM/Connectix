<?php

namespace App\Controller;

use App\Entity\Administration;
use App\Repository\AdministrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Dismiss;


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
        $socity = $this->getUser()->getSocity();
        return $this->render('administration/index.html.twig', [
            'administrations' => $administrationRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/", name="administration_new", methods={"NEW", "POST", "GET"})
     */
    public function new(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $dataform = $form->getData();
            $number = $dataform["number"];

            for ($i=0; $i < $number; $i++){
                $administration = new Administration();
                $coeficientSalary = 1.2;
                $formation = 75;
                $experience = 0;
                $productivity = $formation+$experience;
                $smic = 12*$this->getUser()->getGame()->getSmic();
                $salary = $coeficientSalary*$smic;
                $socity = $this->getUser()->getSocity();
                $administationActivity = $this->getUser()->getGame()->getAnnualHoursWork()*$productivity/100;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork()/50;

                $administration
                    ->setAdministationActivity($administationActivity)
                    ->setAdministrationActivityCost($administrationActivityCost)
                    ->setSocity($socity)
                    ->setCoeficientSalary($coeficientSalary)
                    ->setExprience($experience)
                    ->setFormation($formation)
                    ->setProductivity($productivity)
                    ->setSalary($salary)
                ;

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($administration);
            }

            $entityManager->flush();

            return $this->redirectToRoute('player_human_ressourcies');
        }

        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'admin'
        ]);
    }



    /**
     * @Route("/", name="administration_cadre_new", methods={"NEW_C", "POST", "GET"})
     */
    public function newCadre(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('number', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataform = $form->getData();
            $number = $dataform["number"];

            for ($i = 0; $i < $number; $i++) {

                $administration = new Administration();
                $coeficientSalary = 3;
                $formation = 75;
                $experience = 0;
                $productivity = $formation + $experience;
                $smic = 12 * $this->getUser()->getGame()->getSmic();
                $salary = $coeficientSalary * $smic;
                $socity = $this->getUser()->getSocity();
                $administationActivity = $this->getUser()->getGame()->getAnnualHoursWork() * $productivity / 100;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork() / 50;

                $administration
                    ->setAdministationActivity($administationActivity)
                    ->setAdministrationActivityCost($administrationActivityCost)
                    ->setSocity($socity)
                    ->setCoeficientSalary($coeficientSalary)
                    ->setExprience($experience)
                    ->setFormation($formation)
                    ->setProductivity($productivity)
                    ->setSalary($salary);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($administration);
            }
            $entityManager->flush();

            return $this->redirectToRoute('player_human_ressourcies');
        }
        return $this->render('up_salary/up_salary.html.twig', [
            'form' => $form->createView(),
            'people' => 'admin'
        ]);
    }
}
