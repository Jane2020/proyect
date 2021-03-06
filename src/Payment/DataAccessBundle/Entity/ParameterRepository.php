<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ParameterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParameterRepository extends EntityRepository
{
	public function isEnabled($firstKey, $endKey, $rolAdmin, $time = false)
	{
		if ($rolAdmin)
		{
			return true;
		}
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('p');
		$queryBuilder->add('select', 'p');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Parameter p');
		$queryBuilder->Where('p.isActive = 1');	
		$queryBuilder->andWhere($queryBuilder->expr()->orX(
				'p.key = ?1',
				'p.key = ?2'));
		if ($time)
		{
			$queryBuilder->orWhere($queryBuilder->expr()->orX(
					'p.key = ?3',
					'p.key = ?4'));
			$queryBuilder->setParameter(3, 'time_start_collection');
			$queryBuilder->setParameter(4, 'time_end_collection');
		}
		$queryBuilder->setParameter(1, $firstKey);
		$queryBuilder->setParameter(2, $endKey);
		$query = $queryBuilder->getQuery();		
		$results = $query->getResult();
	
		foreach ($results as $item)
		{
			$date[$item->getKey()] = $item->getValue();
		}
		$enabled = false;

		if((date('Y-m-d') >= $date[$firstKey])&&(date('Y-m-d') <= $date[$endKey]))
		{
			if($time)
			{
				if((strtotime(date('H:i')) >= strtotime($date['time_start_collection']))&&(strtotime(date('H:i')) < strtotime($date['time_end_collection'])))
				{
					$enabled = true;
				}				
			}else {
				$enabled = true;
			}			
		}
		return $enabled;
	}
}
