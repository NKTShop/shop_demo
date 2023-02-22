<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    // /**
    //  * @Route("/category", name="app_category")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('category/index.html.twig', [
    //         'controller_name' => 'CategoryController',
    //     ]);
    // }

    private CategoryRepository $repo;
    public function __construct(CategoryRepository $repo)
    {
       $this->repo = $repo;
    }
    /**
     * @Route("/categoryy", name="category_show")
     */
    public function allCategoryAction(): Response
    {
        $category = $this->repo->findAll();
        return $this->render('category/index.html.twig', [
            'category'=>$category
        ]);
    }

    //ADMIN
    //ADD Category
    /**
     * @Route("/addcate", name="category_create")
     */
    public function addCategoryAction(CategoryRepository $repo, Request $req): Response
    {
        $cate = new Category();
        $form = $this->createForm(CategoryType::class, $cate);

        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid())
        {
            $repo->add($cate, true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('category/form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    //EDIT Category
    /**
     * @Route("/editcate/{id}", name="category_edit", requirements={"id"="\d+"})
     */
    public function editCategoryAction(CategoryRepository $repo, Request $req, Category $cate): Response
    {
        $form = $this->createForm(CategoryType::class, $cate);

        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $repo->add($cate, true);
            // return new Response('Edited id = '.$cate->getId());
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
            
        }
        return $this->render('category/form.html.twig',[
            'form'=>$form->createView(),
       
        ]);
    }


    //DELETE CATEGORY
        /**
     * @Route("/delete/{id}", name="category_delete",requirements={"id"="\d+"})
     */
    
     public function deleteAction(Request $request, Category $c): Response
     {
         $this->repo->remove($c,true);
         return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
     }


     //USER
         /**
         * @Route("/brand/{id}", name="app_brand")
         */
    public function showbrand(CategoryRepository $repo, $id, Category $category, ProductRepository $repo1): Response
    {   
        $br= $repo->findAll();
        $p= $repo->findbrand($id);
        return $this->render('brand/index.html.twig', [
            'pro'=> $p,
            'brand'=>$br
        ]);
    }
}

