<?php

namespace App\Controller;

use App\Entity\Researcher;
use App\Form\ResearcherType;
use App\Repository\ReseacherRepository;
use App\Repository\ResearcherRepository;
use App\Service\Dismiss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/researcher")
 * Class ResearcherController
 * @package App\Controller
 */
class ResearcherController extends AbstractController
{
    /**
     * @Route("/", name="researcher_index", methods={"GET"})
     * @param ResearcherRepository $reseacherRepository
     * @return Response
     */
    public function index(ResearcherRepository $reseacherRepository): Response
    {
        $socity = $this->getUser()->getSocity();
        return $this->render('researcher/index.html.twig', [
            'researchers' => $reseacherRepository->findBy($socity),
        ]);
    }

    /**
     * @Route("/new", name="researcher_new", methods={"NEW", "POST", "GET"})
     * @param Request $request
     * @return Response
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

            for ($i=0; $i < $number; $i++) {
                $researcher = new Researcher();
                $coeficientSalary = 2.5;
                $formation = 90;
                $experience = 0;
                $productivity = $formation + $experience;
                $smic = $this->getUser()->getGame()->getSmic();
                $salary = $coeficientSalary * $smic;
                $socity = $this->getUser()->getSocity();
                $researchActivity = $this->getUser()->getGame()->getAnnualHoursWork() * $productivity / 100;
                $administrationActivityCost = $this->getUser()->getGame()->getAnnualHoursWork() / 50;

                $researcher
                    ->setResearchActivity($researchActivity)
                    ->setAdministrationActivityCost($administrationActivityCost)
                    ->setSocity($socity)
                    ->setCoeficientSalary($coeficientSalary)
                    ->setExprience($experience)
                    ->setFormation($formation)
                    ->setProductivity($productivity)
                    ->setSalary($salary);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($researcher);
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
