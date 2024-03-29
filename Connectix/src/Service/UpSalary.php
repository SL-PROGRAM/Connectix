<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**.
 * Class UpSalary
 * @package App\Service.
 */
class UpSalary extends AbstractController
{
    /**
     * @param ObjectRepository $Repository
     * @param $salaryUp
     */
    public function salary(ObjectRepository $Repository, $salaryUp){
        $peoples = $Repository->findAll();

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($peoples as  $people){
            $SalaryOld = $people->getSalary();
            $people->setSalary($SalaryOld + ($SalaryOld*$salaryUp/100));
            $entityManager->persist($people);
        }
        $entityManager->flush();
    }

}
