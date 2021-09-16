<?php

namespace App\Controller;



use App\Entity\Favoris;
use App\Entity\Product;
use App\Form\ProductType;
use Cocur\Slugify\Slugify;
// use Doctrine\Persistence\ObjectManager;
use App\Repository\FavorisRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        $product->setFavoris(true);

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
    /**
     * @Route("/remove/favoris/{id}", name="remove_favoris", requirements={"id":"\d+"})
     *
     * @return remove
     */
    public function removeFavoris($id, Product $product): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product->setFavoris(false));
        $entityManager->flush();


        return $this->redirectToRoute('index', [
            'id' => $product->getId($id)
        ]);
    }
    /**
     * Permet de liker ou unliker un article
     * @Route("/post/{id}/like", name="post_like", requirements={"id":"\d+"})
     */
    public function like(Product $product, EntityManagerInterface $manager, FavorisRepository $likeRepo)
    {

        $user = $this->getUser();

        $favoris = new Favoris();
        $favoris->setLikes($user->getUserIdentifier());

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized",
        ], 403);

        if ($product->isFavourite($user)) {
            $like = $likeRepo->findOneBy([
                'likes' => $favoris,
                'user' => $user
            ]);
            $manager->remove($like->setlikes);
            $manager->flush();

            return $this->json(
                [
                    'code' => 200,
                    'message' => 'Supprimé des Favoris',
                    'likeFavoris' => $likeRepo->count(['likes' => $favoris])
                ],
                200
            );
        }
        $like = $product->SetFavoris(true, false);

        $manager->persist($like);
        $manager->flush();

        return $this->json(
            [
                'code' => 200,
                'message' => 'favoris bien ajouté',
                'likeFavoris' => $likeRepo->count(['likes' => $favoris]),
                200
            ]
        );
    }
}
