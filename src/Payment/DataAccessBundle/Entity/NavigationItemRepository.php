<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NavigationItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NavigationItemRepository extends EntityRepository
{
	
	/**
	 * Función que devuelve todos los items para el menú
	 *
	 * @param int $level  Nivel del Menú
	 * @param int $parentId Identificador del Padre del Menú
	 * @param string $sc security
	 *
	 */
	public function getMenus($parentId, $rol)
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('n');
		$queryBuilder->add('select', 'n');
		$queryBuilder->orderBy('n.ordering');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:NavigationItem n');
		$queryBuilder->andWhere($queryBuilder->expr()->eq('n.isActive', '1'));
		$j = 2;				
		foreach ($rol as $item)
		{
			$queryBuilder->orWhere($queryBuilder->expr()->like('n.roles', '?'.$j));
			$queryBuilder->setParameter($j, $item);
			$j++;
		}
		
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}	
}