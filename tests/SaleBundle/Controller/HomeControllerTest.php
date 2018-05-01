<?php


namespace Tests\SaleBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;

class HomeControllerTest extends WebTestCase
{

    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Horaires")')->count());
    }

    public function testOrderPrepareWithoutBooking()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/order/prepare');
        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Aucune réservation n\'a été effectuée")')->count());
    }


}