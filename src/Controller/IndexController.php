<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findAll();


        return $this->render('index/index.html.twig', [
            'products' => $product
        ]);
    }
}
