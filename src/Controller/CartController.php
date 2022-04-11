<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getFull() //to get all the elements in the shopping cart
        ]);
    }


    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id); //to add element(s) to the shopping cart

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove(); //to remove all element(s) in the shopping cart
        
        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/delete/{id}', name: 'app_delete_to_cart')]
    public function deleteProduct(Cart $cart, $id): Response
    {
        $cart->delete($id); //to remove one element in the shopping cart
        
        return $this->redirectToRoute('app_cart');
    }

    //to decrease the quantity of one product in the shopping cart
    #[Route('/cart/decrease/{id}', name: 'app_decrease_to_cart')]
    public function decreaseProduct(Cart $cart, $id): Response
    {
        $cart->decrease($id);  //call the function in cart
        
        return $this->redirectToRoute('app_cart');
    }
}
