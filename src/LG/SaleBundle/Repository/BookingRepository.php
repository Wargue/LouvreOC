<?php

namespace LG\SaleBundle\Repository;


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

}
