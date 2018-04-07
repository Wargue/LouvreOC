<?php

namespace LG\SaleBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="LG\SaleBundle\Repository\BookingRepository")
 */
class Booking
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visitDate", type="datetime")
     * @Assert\DateTime()
     */
    private $visitDate;


    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=50)
     */
    private $type;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     * @Assert\DateTime()
     */
    private $bookingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="contactMail", type="string", length=255)
     * @Assert\Email()
     */
    private $contactMail;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketNumber", type="integer")
     */
    private $ticketNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="totalPrice", type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity="LG\SaleBundle\Entity\Ticket", mappedBy="booking",cascade={"persist"})
     */
    private $tickets;


    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->bookingDate = new \DateTime();
        $this->tickets = new ArrayCollection();
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
     * Set visitDate
     *
     * @param \DateTime $visitDate
     *
     * @return Booking
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set contactMail
     *
     * @param string $contactMail
     *
     * @return Booking
     */
    public function setContactMail($contactMail)
    {
        $this->contactMail = $contactMail;

        return $this;
    }

    /**
     * Get contactMail
     *
     * @return string
     */
    public function getContactMail()
    {
        return $this->contactMail;
    }

    /**
     * Set ticketNumber
     *
     * @return Booking
     */
    public function setTicketNumber()
    {
        $this->ticketNumber = $this->getTickets()->count();

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return int
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return Booking
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Add ticket
     *
     * @param \LG\SaleBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\LG\SaleBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        $ticket->setBooking($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \LG\SaleBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\LG\SaleBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Booking
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
