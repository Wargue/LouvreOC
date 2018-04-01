<?php

namespace LG\SaleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TicketRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByTicketAndBooking($date)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('t')
            ->from('LG\SaleBundle\Entity\Ticket', 't')
            ->innerJoin('t.booking', 'b')
            ->addSelect('b')
            ->where('b.visitDate = :visitDate')
            ->setParameter('visitDate', $date);
        return $query
            ->getQuery()
            ->getResult();

       /* SELECT SUM(`ticketNumber`) FROM booking WHERE `visitDate` = '2018-03-25'*/
    }
}
