<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class Formation
 * @package App\Service
 */
class Formation extends AbstractController
{
    /**
     * @param ObjectRepository $Repository
     * @param $formation
     */
    public function salary(ObjectRepository $Repository, $formation){
        $peoples = $Repository->findAll();

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $formationOld = $people->getFormation();
            $formationNew = $formationOld + ($formationOld*$formation/100);
            $people->setFormation($formationNew);
            $experience = $people->getExprience();
            $people->setProductivity($experience + $formationNew);

            $entityManager->persist($people);
        }
        $entityManager->flush();
    }
}

