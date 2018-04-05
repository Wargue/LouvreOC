<?php

namespace LG\SaleBundle\Repository;


use LG\SaleBundle\Entity\Booking;

class BookingRepository extends \Doctrine\ORM\EntityRepository
{

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

    public function totalTicketByDate(Booking $booking)
    {
        $total = $booking->getTicketNumber();
        $totalByDate = $this->findByBooking($booking->getVisitDate());
        return $total + $totalByDate;
    }

}
