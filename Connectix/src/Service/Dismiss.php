<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class Dismiss extends AbstractController
{
   public function salary(ObjectRepository $Repository, $limit){
        $peoples = $Repository->findBy([], ["exprience" => "DESC"], $limit);

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $entityManager->remove($people);
            dump(1);
        }
        $entityManager->flush();
    }


    public function people(ObjectRepository $Repository, $limit){
        $peoples = $Repository->findBy([], ["exprience" => "ASC"], $limit);

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $entityManager->remove($people);
        }
        $entityManager->flush();
    }

}
