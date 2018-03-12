<?php

namespace LG\SaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="LG\SaleBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @ORM\Column(name="tarif", type="integer")
     */
    private $tarif;

    /**
     * @ORM\Column(name="reducedPrice", type="boolean")
     */
    private $reduced = false;

    /**
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @ORM\ManyToOne(targetEntity="LG\SaleBundle\Entity\Booking", inversedBy="tickets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

    public function __construct()
    {
        $this->tarif = 20;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Ticket
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Ticket
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Ticket
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Ticket
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Ticket
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set tarif
     *
     * @param integer $tarif
     *
     * @return Ticket
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return integer
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set booking
     *
     * @param \LG\SaleBundle\Entity\Booking $booking
     *
     * @return Ticket
     */
    public function setBooking(\LG\SaleBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \LG\SaleBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set reduced
     *
     * @param boolean $reduced
     *
     * @return Ticket
     */
    public function setReduced($reduced)
    {
        $this->reduced = $reduced;

        return $this;
    }

    /**
     * Get reduced
     *
     * @return boolean
     */
    public function getReduced()
    {
        return $this->reduced;
    }
}
