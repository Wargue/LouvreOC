<?php

namespace LG\SaleBundle\Repository;


class BookingRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByBooking($date)
    {
        $query = $this->getEntityManager()->createQueryBuilder('b');
        $query
            ->select('SUM(b.ticketNumber)')
            ->from('LG\SaleBundle\Entity\Booking', 'b')
            ->where('b.visitDate = :visitDate')
            ->setParameter('visitDate', $date);
        return $query
            ->getQuery()
            ->getScalarResult();
    }

}
