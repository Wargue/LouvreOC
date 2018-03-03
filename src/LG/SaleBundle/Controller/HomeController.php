<?php

// src/LG/SaleBundle/Controller/HomeController.php

namespace LG\SaleBundle\Controller;

use LG\SaleBundle\Entity\Booking;
use LG\SaleBundle\Entity\Ticket;
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
    public function priceAction(Request $request)
    {
        $ticket = new Ticket();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $ticket)
            ->add('nom',                    TextType::class)
            ->add('prenom',                 TextType::class)
            ->add('nationalite',            TextType::class)
            ->add('birthday',               DateType::class)
            ->add('save',                   SubmitType::class)
            ->getForm();
            ;

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Réservation enregistrée');

                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('home', array('id' => $ticket->getId()));
            }
        }

        return $this->render('LGSaleBundle:Sale:selling.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}