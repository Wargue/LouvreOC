<?php

// src/LG/SaleBundle/Controller/HomeController.php

namespace LG\SaleBundle\Controller;


use LG\SaleBundle\CalcPrice\CalcPrice;
use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;
use LG\SaleBundle\Form\BookingType;
use LG\SaleBundle\SendMailer\SendMailer;
use LG\SaleBundle\Stripe\Stripe;
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
use LG\SaleBundle\Repository\BookingRepository;

/**
 * Class HomeController
 * @package LG\SaleBundle\Controller
 */
class HomeController extends Controller
{
    const MAXBILLET = 1000;

    /**
     * @route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('LGSaleBundle:Sale:index.html.twig');
    }

    /**
     * @route("/reservation", name="price")
     */
    public function priceAction(Request $request, CalcPrice $calcPrice)
    {
        $form = $this->createForm(BookingType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /* On récupère les données*/
            $booking = $form->getData();

            /*On initie le calcul*/
            $calcPrice->calculatePrice($booking);

            $booking->setTicketNumber();


            $quantity = $this ->getDoctrine()
                ->getManager()
                ->getRepository('LGSaleBundle:Booking')
                ->totalTicketByDate($booking);

            if ($quantity < self::MAXBILLET){
                $request->getSession()->set('booking', $booking);
                // partie form en texte indiquant que tout a été correctement enregistrer et qu'un mail sera envoyé ?
                return $this->redirectToRoute('Ticket', array('id' => $booking->getId() ));
            }
        }
        return $this->render('LGSaleBundle:Sale:selling.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @route("/reservation/ticket", name="Ticket")
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
        if (null === $booking){
            $this->addFlash("notice",'Aucune réservation n\'a été effectuée');
            return $this->redirectToRoute('price');
        }

        return $this->render('LGSaleBundle:Sale:prepare.html.twig', array('booking' => $booking));
    }

    /**
     * @Route("/checkout", name="order_checkout", methods="POST")
     */
    public function stripeCheckout(Stripe $stripe, Request $request, SendMailer $mailer){

        $stripePay = $stripe->checkoutAction($request->get('stripeToken'));

        if ($stripePay){

            $booking = $request->getSession()->get('booking');
            $em = $this->getDoctrine()->getManager();
            $em ->persist($booking);
            $em ->flush();

            $code = substr(bin2hex(openssl_random_pseudo_bytes(100)), 0, 6);
            $mailer->sendMail($booking,$code);

            $this->addFlash("notice","Bravo ça marche !");

            $request->getSession()->remove('booking');

            return $this->redirectToRoute("price");
        }

        $this->addFlash("notice",$stripePay);
        return $this->redirectToRoute("order_prepare");
        // The card has been declined
    }

}