<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(ProductRepository $repo, CategoryRepository $repo1, Request $req ): Response
    {   
        return $this->render('registration/index.html.twig', [
            
            'controller_name' => 'RegistrationController',
        ]);
    }
    
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, 
    EntityManagerInterface $entityManager, ProductRepository $repo, CategoryRepository $repo1, Request $req ): Response
    {   
        $br = $repo1->findAll();
        $products = $repo->findAll();
        $user=new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            //encodde the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                $user,
                $form->get('password')->getData()

                )
            );
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();
            //do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            
            'registrationForm'=>$form->createView(),
            'products' => $products,
            'brand' => $br
            
        ]);
    }
    
}
