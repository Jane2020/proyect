<?php
namespace Payment\MeterBundle\Form\Type;

use Payment\DataAccessBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsumptionEditType extends AbstractType
{
	private $isOperator;
	private $em;
	private $accounts;

	
	public function __construct($entityManager,$rol,$accountId)
	{
		$this->em = $entityManager;
		$this->isOperator = $rol;
		$this->accounts = $this->getAccounts($accountId);		
	}
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		$builder->add('id','hidden');
		$builder->add('account', 'entity', array(
				'class' => 'PaymentDataAccessBundle:Account',
				'query_builder' => $this->getQueryBuilder(),
				'property' => 'accountNumber',
				'empty_value' => '',
				'label' => '# Conexión',
				'required' => false,
		));
		$builder->add('meterCurrentReading','text',  array('label'=>'Lectura de Medidor', 'required'=>false, 'max_length'=>11));
		if (!$this->isOperator)
		{
			$builder->add('description','textarea',  array('label'=>'Observaciones:', 'required'=>false, 'max_length'=>512));
		}
		
		$builder->add('readDate','text',  array('label'=>'Fecha de Lectura:', 'required'=>false, 'max_length'=>10));
	}

	public function getName()
	{
		return 'consumptionEdit';
	}
	
	private function getAccounts($accountId)
	{
		$queryBuilder = $this->em->createQueryBuilder('c');
		$queryBuilder->add('select', 'c');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Consumption c');
		$queryBuilder->innerJoin('PaymentDataAccessBundle:Parameter', 'p', 'WITH', 'p.id = 1');
		$queryBuilder->innerJoin('PaymentDataAccessBundle:Parameter', 'p1', 'WITH', 'p1.id = 2');
		$queryBuilder->Where('c.isDeleted = 0');
		$queryBuilder->andWhere('c.systemDate >= p.value');
		$queryBuilder->andWhere('c.systemDate <= p1.value');
		$query = $queryBuilder->getQuery();
		$results = $query->getResult();
		$data = array();
		foreach ($results as $result)
		{
			if($result->getAccount()->getId() != $accountId)
			{
				$data[] = $result->getAccount()->getId();
			}
		}		
		return $data;
	}

	private function getQueryBuilder()
	{		
		$qb = $this->em->createQueryBuilder('a');
		$qb->add('select', 'a');
		$qb->add('from', 'PaymentDataAccessBundle:Account a');
	 	$qb->where('a.isActive = 1')
		->andWhere($qb->expr()->notIn('a.id', $this->accounts))
		->orderBy('a.accountNumber', 'ASC');
		return $qb;		
	}
}