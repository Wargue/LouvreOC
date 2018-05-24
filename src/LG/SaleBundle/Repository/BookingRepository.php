<?php

namespace LG\SaleBundle\Repository;


use LG\SaleBundle\Entity\Booking;

class BookingRepository extends \Doctrine\ORM\EntityRepository
{

    const MAXBILLET = 1000;

    /**
     * @param $date
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByBooking($date)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('SUM(b.ticketNumber) as quantity')
            ->from('LG\SaleBundle\Entity\Booking', 'b')
            ->where('b.visitDate = :visitDate')
            ->setParameter('visitDate', $date);
        return $query
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param Booking $booking
     * @return int|mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function totalTicketByDate(Booking $booking)
    {
        $total = $booking->getTicketNumber();
        $totalByDate = $this->findByBooking($booking->getVisitDate());
        return $total + $totalByDate;
    }

    /**
     * @param Booking $booking
     * @return int|mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function numberTicketControl(Booking $booking)
    {
        /* On calcul le nombre de ticket existant déjà réservés additionnés à ceux que l'on réserve en ce moment et on vérifie que la quantité est inférieure à 1000 tickets*/
        $quantity = $this->totalTicketByDate($booking);

        if ($quantity > self::MAXBILLET){
            return false;
        }
        return true;
    }

}
