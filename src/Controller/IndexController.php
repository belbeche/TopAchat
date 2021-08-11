<?php

namespace App\Controller;



use App\Entity\Product;
use App\Form\ProductType;
use Cocur\Slugify\Slugify;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepo, Request  $request, PaginatorInterface $paginator): Response
    {
        // Formulaire de recherche 
        // $data = new SearchData();

        // $form = $this->createForm(SearchForm::class, $data);
        // $form->handleRequest($request);
        $slugify = new Slugify();
        $slugify->slugify('Hello World!'); // hello-world

        $product = $paginator->paginate(
            $productRepo->findAll(),
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('index/index.html.twig', [
            'products' => $product,
            'slug' => $slugify
            // 'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("addFavoris/{id}", name="addFavoris")
     *
     * @return objet
     */
    public function addFavoris($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Erreur 404 : Annonce not found for : id : ' . $id
            );
        }

        $product->setFavoris($id);

        $entityManager->persist($product);
        $entityManager->flush();

        // $favoris = new Product();
        // $favoris->setFavoris($id, $request);
        // $form = $this->createForm(ProductType::class, $favoris);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $favoris = $form->getData();
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($favoris);
        //     $entityManager->flush();
        // }
        return $this->redirectToRoute('index', [
            'id' => $product->getId()
        ]);
    }
}
