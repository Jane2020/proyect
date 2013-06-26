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
		$builder->add('consumptionHave', 'checkbox', array(
				'label'     => 'No Tiene Consumo',
				'required'  => false,
		));
		if (!$this->isOperator)
		{
			$builder->add('description','textarea',  array('label'=>'Observaciones:', 'required'=>false, 'max_length'=>512));
		}
		
		$builder->add('readDate','choice',  array('label'=>'Mes de Lectura:', 'required'=>false, 
				'choices'=>array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre')
				,'empty_value' => 'Seleccione',
		));
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
		$queryBuilder->innerJoin('PaymentDataAccessBundle:Parameter', 'p', 'WITH', "p.key = 'date_start_consumption'");
		$queryBuilder->innerJoin('PaymentDataAccessBundle:Parameter', 'p1', 'WITH', "p1.key = 'date_end_consumption'");
		$queryBuilder->Where('c.isDeleted = 0');
		$queryBuilder->andWhere('c.systemDate >= p.value');
		$queryBuilder->andWhere("c.systemDate <= DATE_ADD(p1.value,1,'day')");
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
	 	$qb->where('a.isActive = 1');
	 	if (count($this->accounts) > 0)
	 	{
	 		$qb->andWhere($qb->expr()->notIn('a.id', $this->accounts));
	 	}
		
		$qb->orderBy('a.accountNumber', 'ASC');
		return $qb;		
	}
}