<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class Dismiss
 * @package App\Service
 */
class Dismiss extends AbstractController
{
    /**
     * @param ObjectRepository $Repository
     * @param $limit
     */
   public function salary(ObjectRepository $Repository, $limit){
        $peoples = $Repository->findBy([], ["exprience" => "DESC"], $limit);

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $entityManager->remove($people);
            dump(1);
        }
        $entityManager->flush();
    }

    /**
     * @param ObjectRepository $Repository
     * @param $limit
     */
    public function people(ObjectRepository $Repository, $limit){
        $peoples = $Repository->findBy([], ["exprience" => "ASC"], $limit);

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $entityManager->remove($people);
        }
        $entityManager->flush();
    }

}
