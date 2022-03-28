<?php

namespace App\Controller;

use App\Class\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/produits', name: 'app_products')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$search = $form->getData();
            //dd($search);
            $products = $doctrine->getRepository(Product::class)->findWithSearch($search);
        }
        else{
            $products = $doctrine->getRepository(Product::class)->findAll();
        }     

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    #[Route('/produit/{id}', name: 'app_product')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product){
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }



}
