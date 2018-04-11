<?php
// src/LG/SaleBundle/Mailer/Mailer.php

namespace LG\SaleBundle\Mailer;

use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;

class Mailer
{

    public function sendMail(\Swift_Mailer $swiftMailer){

        $view =

        $message = new \Swift_Message('Confirmation de réservation - Le Louvre');
        $message->setBody($view);



    }
}