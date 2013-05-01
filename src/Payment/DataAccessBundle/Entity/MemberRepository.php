<?php	

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MemberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MemberRepository extends EntityRepository
{
	public function findMemberByParametersToList($memberName, $memberLastname ,$memberDocumentNumber, $offset, $limit, $count = true)
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('m');
		if ($count) 
		{
			$queryBuilder->add('select', $queryBuilder->expr()->count('m.id'));
		} 
		else 
		{
			$queryBuilder->add('select', 'm');
			$queryBuilder->orderBy('m.name');
			$queryBuilder->setFirstResult($offset);
			$queryBuilder->setMaxResults($limit);
		}
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Member m');
		 
		if ($memberName != null) 
		{
			$memberName = str_replace(' ', '%', $memberName);
			$memberName = '%' . strtolower($memberName) . '%';
			$queryBuilder->where($queryBuilder->expr()->like($queryBuilder->expr()->lower('m.name'), '?1'));
			$queryBuilder->setParameter(1, $memberName);
		}
		
		if ($memberLastname != null)
		{
			$memberLastname = str_replace(' ', '%', $memberLastname);
			$memberLastname = '%' . strtolower($memberLastname) . '%';
			$queryBuilder->andWhere($queryBuilder->expr()->like($queryBuilder->expr()->lower('m.lastname'), '?2'));
			$queryBuilder->setParameter(2, $memberLastname);
		}
		
		if ($memberDocumentNumber != null)
		{
			$memberDocumentNumber = str_replace(' ', '%', $memberDocumentNumber);
			$memberDocumentNumber = '%' . strtolower($memberDocumentNumber) . '%';
			$queryBuilder->andWhere($queryBuilder->expr()->like($queryBuilder->expr()->lower('m.documentNumber'), '?3'));
			$queryBuilder->setParameter(3, $memberDocumentNumber);
		}
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}	
}