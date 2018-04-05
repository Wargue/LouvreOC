<?php
// src/LG/SaleBundle/CalcPrice/CalcPrice.php

namespace LG\SaleBundle\CalcPrice;

use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;

class CalcPrice
{

    public function calculatePrice(Booking $booking){

        $totprice = 0;

        /**
         * @var $ticket Ticket
         */
        foreach ($booking->getTickets() as $ticket)
        {

            dump($ticket->getBirthday()->format('Y'));

            $year = $ticket->getBirthday()->format('Y');

            $now = new \DateTime();
            $today = $now->format('Y');

            $age = $today - $year;

            dump($age);
            /**
             * MISE EN PLACE DU PRIX DES TICKETS SELON L AGE
             */
            switch (true){
                case $age < 4:
                    $ticket->setTarif(0);
                    break;
                case $age < 12:
                    $ticket->setTarif(8);
                    break;
                case $age < 60:
                    $ticket->setTarif(16);
                    break;
                case $age >= 60:
                    $ticket->setTarif(12);
            }
            dump($ticket->getTarif());

            if ($ticket->getReduced()=='true'){
                $tarifRed = $ticket->getTarif();
                $ticket->setTarif($tarifRed-10);
            }
            dump($ticket->getTarif());
            $totprice = $totprice + $ticket->getTarif();
        }
        $booking->setTotalPrice($totprice);
    }
}





