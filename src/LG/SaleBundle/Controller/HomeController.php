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
        $form=$this->createForm(BookingType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {

            $booking= $form->getData();


        $result=($calcPrice->calculatePrice($booking));

        dump($result);

            $booking->setTicketNumber();
            dump($booking->getTicketNumber());
            die();
                //Partie à retravailler => Créer les validations
                $em = $this->getDoctrine()->getManager();
                $em->persist($booking);

                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Réservation enregistrée');

                //Partie à retravailler => créer la vue / Utiliser Javascript pour changer le contenu de la
                // partie form en texte indiquant que tout a été correctement enregistrer et qu'un mail sera envoyé ?
                return $this->redirectToRoute('home', array('id' => $booking->getId()));
        }

        return $this->render('LGSaleBundle:Sale:selling.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}