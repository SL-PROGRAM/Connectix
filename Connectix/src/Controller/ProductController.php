<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/product")
 * @ISGranted("ROLE_USER")
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{


    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function showSales(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'path' => $_GET["path"]
        ]);
    }

}
