<?php
// src/LG/SaleBundle/SendMailer/SendMailer.php.php

namespace LG\SaleBundle\SendMailer;

use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;

class SendMailer
{

    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    /*
     * mail view calling
     */
    public function mailView($booking, $code){

        return $this->templating->render('LGSaleBundle:Sale:mail.html.twig', array('booking' => $booking, 'code' => $code));
    }

    /*
     * mail configuration
     */
    public function sendMail($booking, $code){


        $view = $this->mailView($booking, $code);

        $message = new \Swift_Message('Confirmation de réservation - Le Louvre');
        $message
            ->setFrom('gillet_l@hotmail.com')
            ->setTo('gillet_l@hotmail.com')
            ->setBody($view)
            ->setContentType("text/html");

        dump($message);
        dump($view);

        $this->mailer->send($message);


    }




}