<?php
// src/LG/SaleBundle/Stripe/Stripe.php

namespace LG\SaleBundle\Stripe;

use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;


class Stripe
{
    /**
     * @Route("order/prepare", name="order_prepare")
     */
    public function prepareAction(Request $request, Booking $booking)
    {
        $booking = $request->getSession()->get('booking');
        return $this->render('LGSaleBundle:Sale:prepare.html.twig', array('booking' => $booking));
    }

    /**
     * @Route("/checkout", name="order_checkout", methods="POST")
     */
    public function checkoutAction(Request $request, Booking $booking)
    {
        $booking = $request->getSession()->get('booking');

        \Stripe\Stripe::setApiKey("sk_test_6G5KOdv94H6JCMTaqEyPnB7s");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $booking->getTotalPrice()*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Le Louvre"
            ));
            $this->addFlash("notice","Bravo ça marche !");
            $em->flush($booking);
            return $this->redirectToRoute("Price");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("notice","Snif ça marche pas :(");
            return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }


    }



}