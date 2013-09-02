<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IncomeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncomeRepository extends EntityRepository
{
	public function findIncomeByAccount($paymentId)
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('i');
		$queryBuilder->add('select', 'i');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Income i');
		$queryBuilder->andWhere('i.payment = ?1');
		$queryBuilder->setParameter(1, $paymentId);
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	public function getStateAccount($account, $year)
	{
		$queryBuilder1 = $this->getEntityManager()->createQueryBuilder('t');
		$queryBuilder1->add('select', 'distinct(t.id)');
		$queryBuilder1->add('from', 'PaymentDataAccessBundle:Income i1');
		$queryBuilder1->innerJoin('i1.transaction', 't');
		$queryBuilder1->innerJoin('i1.consumption', 'c');
		$queryBuilder1->innerJoin('c.account', 'a');
		$queryBuilder1->where('a.id = ?1');
		$queryBuilder1->andwhere($queryBuilder1->expr()->like('c.systemDate', '?2'));
		$queryBuilder1->setParameter(1, $account->getId());
		$queryBuilder1->setParameter(2, $year.'%');
		
		$query = $queryBuilder1->getQuery();
		$result = $query->getResult();
		
		$ids = array();
		foreach ($result as $item)
		{
			$ids[] = $item['id'];
		}

		$queryBuilder = $this->getEntityManager()->createQueryBuilder('i');
		$queryBuilder->add('select', 'i');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Income i');		
		$queryBuilder->innerJoin('i.transaction', 't1');
		$queryBuilder->where($queryBuilder->expr()->in('t1.id', $ids));
		$queryBuilder->orderBy('t1.systemDate');
		$queryBuilder->addOrderBy('i.id');

		$query = $queryBuilder->getQuery();
		$result = $query->getResult();

		return $result;
	}
}