<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\UsersCreateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersProductController extends AbstractController
{
    /**
     * @Route("/demo", name="users_product")
     */
    public function index(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(UsersCreateType::class, $product);
        $form->handleRequest($request);

        return $this->render('users_product/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
