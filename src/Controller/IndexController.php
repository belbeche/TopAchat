<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findAll();

        return $this->render('index/index.html.twig', [
            'products' => $product
        ]);
    }
}
