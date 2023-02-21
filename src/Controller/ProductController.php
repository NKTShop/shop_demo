<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


// /**

class ProductController extends AbstractController
{

    //ADMIN
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/productt", name="product_show")
     */
    public function readAllAction(): Response
    {
        $products = $this->repo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/{id}", name="product_detail",requirements={"id"="\d+"})
     */
    public function showAction(Product $p, CategoryRepository $repo, $id): Response
    {
        // $p = $repo->findbrand($id);
        $br = $repo->findAll();
        return $this->render('product/detail.html.twig', [
            'p' => $p,
            'brand' => $br
        ]);
    }

    //ADD
    /**
     * @Route("/addproduct", name="product_create")
     */
    public function createAction(Request $req, SluggerInterface $slugger): Response
    {

        $p = new Product();
        $form = $this->createForm(ProductType::class, $p);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile, $slugger);
                $p->setImage($newFilename);
            }
            $this->repo->add($p, true);
            return $this->redirectToRoute('product_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("product/form.html.twig", [
            'form' => $form->createView()
        ]);
    }

    //EDIT
    /**
     * @Route("/edit/{id}", name="product_edit",requirements={"id"="\d+"})
     */
    public function editAction(
        Request $req,
        Product $p,
        SluggerInterface $slugger
    ): Response {

        $form = $this->createForm(ProductType::class, $p);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile, $slugger);
                $p->setImage($newFilename);
            }
            $this->repo->add($p, true);
            return $this->redirectToRoute('product_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("product/form.html.twig", [
            'form' => $form->createView()
        ]);
    }

    public function uploadImage($imgFile, SluggerInterface $slugger): ?string
    {
        $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
        try {
            $imgFile->move(
                $this->getParameter('image_dir'),
                $newFilename
            );
        } catch (FileException $e) {
            echo $e;
        }
        return $newFilename;
    }

    /**
     * @Route("/delete/{id}",name="product_delete",requirements={"id"="\d+"})
     */

    public function deleteAction(Request $request, Product $p): Response
    {
        $this->repo->remove($p, true);
        return $this->redirectToRoute('product_show', [], Response::HTTP_SEE_OTHER);
    }

    // /**
    //  * @Route("/findpro/{id}", name="app_findpro",requirements={"id"="\d+"})
    //  */
    // public function findproduct(Product $pr)
    // {
    //     return $this->render('product/find.html.twig', array(
    //         'products' => $pr
    //     ));
    // }





    // USER
    // /**
    //  * @Route("/product", name="app_product")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('product/index.html.twig', [
    //         'controller_name' => 'ProductController',
    //     ]);
    // }

    // /**
    //  * @Route("/detail", name="app_detailll")
    //  */
    // public function detailll(): Response
    // {
    //     return $this->render('product/detail.html.twig', [
    //         'controller_name' => 'ProductController',
    //     ]);
    // }

    // /**
    //  * @Route("/showpr", name="app_showall")
    //  */
    // public function showallProduct(ProductRepository $repo, Request $req): Response
    // {
    //     $products = $repo->findAll();
    //     return $this->render('product/show.html.twig', [
    //         'products' => $products
    //     ]);
    // }

    /**
     * @Route("/showpr", name="app_showall")
     */
    public function showallProductt(ProductRepository $repo, CategoryRepository $repo1, Request $req): Response
    {
        $br = $repo1->findAll();
        $products = $repo->findAll();
        return $this->render('product/show.html.twig', [
            'products' => $products,
            'brand' => $br

        ]);
    }

    /**
         * @Route("/search", name="search", methods={"GET"})
         */
        public function actionSearch(Request $req, ProductRepository $repo, CategoryRepository $repo1): Response
        {
            $br = $repo1->findAll();
            $sName = $req->query->get("search"); 
            $product= $repo->findBysearchproduct($sName);
            return $this->render('search/index.html.twig', [
                'pro' => $product,
                'brand' => $br
            ]);
        }
}
