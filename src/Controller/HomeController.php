<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function homepage(CategoryRepository $repo, CategoryRepository $brand): Response
    {   $br= $brand->findAll();
        $pro= $repo->findAll();
        return $this->render('home/index.html.twig', [
            'pro'=> $pro,
            'brand'=>$br
        ]);
    }

    /**
     * @Route("/brand", name="nameBrand")
     */
    public function showBrand(CategoryRepository $repo, $brand): Response
    {
        $br= $brand->findAll();
        $pro= $repo->findAll();
        return $this->render('base.html.twig', [
            'pro'=> $pro,
            'brand'=>$br
        ]);
    }
}
