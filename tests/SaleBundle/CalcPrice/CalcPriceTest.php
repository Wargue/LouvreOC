<?php
/**
 * Created by PhpStorm.
 * User: laurent
 * Date: 25/04/2018
 * Time: 22:13
 */

namespace Tests\SaleBundle\CalcPrice;


use LG\SaleBundle\CalcPrice\CalcPrice;
use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalcPriceTest extends WebTestCase
{
    public function testCalcPrice()
    {
        $booking = new Booking();

        $ticketOne = new Ticket();
        $birthday = new \DateTime("1989-01-27 00:00:00");
        $ticketOne->setBirthday($birthday);

        $ticketTwo = new Ticket();
        $birthday = new \DateTime("1940-01-27 00:00:00");
        $ticketTwo->setBirthday($birthday);

        $booking->addTicket($ticketOne);
        $booking->addTicket($ticketTwo);

        $calcPrice = new CalcPrice();
        $calcPrice->calculatePrice($booking);
        $this->assertEquals(28, $booking->getTotalPrice());
    }

    public function testCalcPriceChildLessThanFour()
    {
        $booking = new Booking();

        $ticket = new Ticket();
        $birthday = new \DateTime("2017-01-27 00:00:00");
        $ticket->setBirthday($birthday);

        $booking->addTicket($ticket);

        $calcPrice = new CalcPrice();
        $calcPrice->calculatePrice($booking);
        $this->assertEquals(0,$booking->getTotalPrice());
    }

    public function testCalcPriceSeniorMoreThanSixty()
    {
        $booking = new Booking();

        $ticket = new Ticket();
        $birthday = new \DateTime("1955-01-27 00:00:00");
        $ticket->setBirthday($birthday);

        $booking->addTicket($ticket);

        $calcPrice = new CalcPrice();
        $calcPrice->calculatePrice($booking);
        $this->assertEquals(12,$booking->getTotalPrice());
    }

}