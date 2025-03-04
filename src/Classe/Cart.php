<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    // Création de constructeur et injection de dependance permettant d'aller chercher les sessions
    public function __construct(private RequestStack $requestStack) {}

    // fonction permettant l'ajout du produit au panier
    public function add($product)
    {
        // appele de la session Cart de symfony
        $cart = $this->requestStack->getSession()->get('cart');
        // dd($session);

        // Si il y a deja le produit ds le panier
        if (isset($cart[$product->getId()])) {

            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {

            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1
            ];
        }


        // Créer ma session Cart
        $this->requestStack->getSession()->set('cart', $cart);
    }


    // fonction permettant de supprimer totalement le panier
    public function remove()
    {
        // Contenu du panier en cours
        return $this->requestStack->getSession()->remove('cart');
    }




    // fonction permettant de retourner le panier en cours
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}
