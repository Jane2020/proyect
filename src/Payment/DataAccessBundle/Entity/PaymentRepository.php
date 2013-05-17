<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentRepository extends EntityRepository
{
	public function findPaymentTypeByNameToList($paymentTypeText, $offset, $limit, $count = true)
	{
	
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('ft');
		if ($count) 
		{
			$queryBuilder->add('select', $queryBuilder->expr()->count('ft.id'));
		} else {
			$queryBuilder->add('select', 'ft');
			$queryBuilder->orderBy('ft.name');
			$queryBuilder->setFirstResult($offset);
			$queryBuilder->setMaxResults($limit);
		}
		$queryBuilder->add('from', 'PaymentDataAccessBundle:PaymentType ft');
		if ($paymentTypeText != null) 
		{
			$paymentTypeText = str_replace(' ', '%', $paymentTypeText);
			$paymentTypeText = '%' . strtolower($paymentTypeText) . '%';
			$queryBuilder->andWhere(
					$queryBuilder->expr()->like($queryBuilder->expr()->lower('ft.name'), '?1')
			);
			$queryBuilder->setParameter(1, $paymentTypeText);
	
		}
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	public function findPaymentByNameToList($paymentText, $offset, $limit, $count = true)
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('p');
		if ($count)
		{
			$queryBuilder->add('select', $queryBuilder->expr()->count('p.id'));
		} 
		else 
		{
			$queryBuilder->select(array('p', 'me', 'pt'));
			$queryBuilder->orderBy('p.paymentDate');
			$queryBuilder->setFirstResult($offset);
			$queryBuilder->setMaxResults($limit);
		}
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Payment p');
		$queryBuilder->innerJoin('p.paymentType', 'pt');
		$queryBuilder->leftJoin('p.member', 'me');
		$queryBuilder->leftJoin('p.account', 'a');
		$queryBuilder->leftJoin('a.member', 'me1');
		$queryBuilder->where($queryBuilder->expr()->eq('p.isDeleted', '0'));
		
		if ($paymentText != null)
		{
			$paymentText = str_replace(' ', '%', $paymentText);
			$paymentText = '%' . strtolower($paymentText) . '%';
			$queryBuilder->andWhere($queryBuilder->expr()->orX(
					$queryBuilder->expr()->like($queryBuilder->expr()->lower('me.name'), '?1'),
					$queryBuilder->expr()->like($queryBuilder->expr()->lower('me1.name'), '?1')																									
			));						
			$queryBuilder->setParameter(1, $paymentText);			
		}
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}
}