<?php
// src/LG/SaleBundle/Stripe/Stripe.php

namespace LG\SaleBundle\Stripe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Stripe
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this-> session = $session;
    }

    public function checkoutAction()
    {
        $booking = $this->session->get('booking');

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

          return true;

        } catch(\Stripe\Error\Card $e) {
            return $e->getMessage();
        }


    }



}