<?php

// src/LG/SaleBundle/Controller/HomeController.php

namespace LG\SaleBundle\Controller;

use LG\SaleBundle\CalcPrice\CalcPrice;
use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;
use LG\SaleBundle\Form\BookingType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class HomeController
 * @package LG\SaleBundle\Controller
 */
class HomeController extends Controller
{

    /**
     * @route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('LGSaleBundle:Sale:index.html.twig');
    }

    /**
     * @route("/Reservation", name="Price")
     */
    public function priceAction(Request $request, CalcPrice $calcPrice)
    {
        $form = $this->createForm(BookingType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /* On récupère les données*/
            $booking = $form->getData();

            /*On initie le calcul*/
            $result = ($calcPrice->calculatePrice($booking));


            $booking->setTicketNumber();

            //Partie à retravailler => Créer les validations
            $em = $this->getDoctrine()->getManager();

            $em->persist($booking);

            $quantity = $this ->getDoctrine()
                ->getManager()
                ->getRepository('LGSaleBundle:Ticket')
                ->findByTicketAndBooking($booking->getVisitDate());

            $nbVisit = count($quantity);

            if ($nbVisit < 1000){

                $request->getSession()->set('booking', $booking);
                //Partie à retravailler => créer la vue / Utiliser Javascript pour changer le contenu de la
                // partie form en texte indiquant que tout a été correctement enregistrer et qu'un mail sera envoyé ?
                return $this->redirectToRoute('Ticket', array('id' => $booking->getId() ));
            }
        }

        return $this->render('LGSaleBundle:Sale:selling.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @route("/Reservation/Ticket", name="Ticket")
     */
    public function ticketAction(Request $request)
    {
       $booking = $request->getSession()->get('booking');


       return $this->render('LGSaleBundle:Sale:ticket.html.twig', array('booking' => $booking));

    }

    /**
     * @Route("order/prepare", name="order_prepare")
     */
    public function prepareAction(Request $request)
    {
        $booking = $request->getSession()->get('booking');
        return $this->render('LGSaleBundle:Sale:prepare.html.twig', array('booking' => $booking));
    }

    /**
     * @Route("/checkout", name="order_checkout", methods="POST")
     */
    public function checkoutAction(Request $request)
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
            return $this->redirectToRoute("Price");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("notice","Snif ça marche pas :(");
            return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }
    }


}