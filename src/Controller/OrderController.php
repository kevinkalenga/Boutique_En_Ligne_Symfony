<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class OrderController extends AbstractController
{
    #[Route('/commande/livraison', name: 'app_order')]
    public function index(): Response
    {
        $addresses = $this->getUser()->getAddresses();

        if (count($addresses) == 0) {
            return $this->redirectToRoute('app_account_address_form');
        }

        $form = $this->createForm(OrderType::class, null, [
            'addresses' => $addresses,
            'action' => $this->generateUrl('app_order_summary')
        ]);

        return $this->render('order/index.html.twig', [
            'deliverForm' => $form->createView(),
        ]);
    }


    /*
    * 2eme etape du tunel d'achat
    * Récap de la commande de l'utilisateur
    * Insertion en base de donnée
      Préparation du paiement vers Stripe
    */
    #[Route('/commande/recapitulatif', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart): Response
    {
        if ($request->getMethod() != 'POST') {
            return $this->redirectToRoute('app_cart');
        }



        $form = $this->createForm(OrderType::class, null, [
            'addresses' => $this->getUser()->getAddresses(),

        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // stocker les informations dans la BDD

            // Création de la chaine d'addresse


        }

        return $this->render('order/summary.html.twig', [
            'choices' => $form->getData(),
            'cart' => $cart->getCart(),
            'totalWt' => $cart->getTotalWt()


        ]);
    }
}
