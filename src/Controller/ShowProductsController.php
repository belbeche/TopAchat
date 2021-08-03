<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowProductsController extends AbstractController
{
    /**
     * @Route("/show/products/{id}", name="show_products")
     */
    public function index(Product $products, $id): Response
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);

        $products = $repository->find($id);


        return $this->render('show_products/index.html.twig', [
            'product' => $products,
        ]);
    }
}
