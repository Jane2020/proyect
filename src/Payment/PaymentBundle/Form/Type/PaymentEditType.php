<?php
namespace Payment\PaymentBundle\Form\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class PaymentEditType extends AbstractType
{
	private $em;
	private $accounts;
	private $id; 
	
	public function __construct($entityManager,$accountId, $id)
	{
		$this->em = $entityManager;
		$this->id = $id;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		if ($this->id == 2)
		{
			$builder->add('account', 'entity', array(
				'class' => 'PaymentDataAccessBundle:Account',
				'query_builder' => $this->getQueryBuilder(),
				'property' => 'accountNumber',
				'empty_value' => '',
				'label' => '# Conexión',
				'required' => false,
			));
		}
		if ($this->id == 1)
		{
			$builder->add('memberId','hidden');
			$builder->add('memberName','text',  array('label'=>'Nombre del Miembro:', 'required'=>false, 'max_length'=>128));
		}
		$builder->add('paymentType', 'entity',array(  
				'class' => 'PaymentDataAccessBundle:PaymentType',
				'query_builder' => $this->getQueryBuilderPaymentType(),
				'property' => 'name',
				'empty_value' => 'Seleccione',
				'label' => 'Tipo de Infracción:',
				'required' => false,
		));
		$builder->add('paymentDate','text',  array('label'=>'Fecha de Infracción:', 'required'=>false, 'max_length'=>10));
		$builder->add('isRecidivism','checkbox',  array('label'=>'Reincidencia en Infracción: ', 'required'=>false,));
	}
	
	private function getQueryBuilder()
	{
		$qb = $this->em->createQueryBuilder('a');
		$qb->add('select', 'a');
		$qb->add('from', 'PaymentDataAccessBundle:Account a');
		$qb->where('a.isActive = 1');
			
		$qb->orderBy('a.accountNumber', 'ASC');
		return $qb;
	}
	
	private function getQueryBuilderPaymentType()
	{
		$qb = $this->em->createQueryBuilder('p');
		$qb->add('select', 'p');
		$qb->add('from', 'PaymentDataAccessBundle:PaymentType p');
		$qb->innerJoin('p.paymentTypeType', 'pt');
		$qb->where($qb->expr()->eq('pt.id', '?1'));
		$qb->andwhere($qb->expr()->eq('p.isActive', '1'));
		$qb->setParameter(1,$this->id);
		$qb->orderBy('p.name', 'ASC');
		return $qb;		
	}
	
	public function getName()
	{
		return 'paymentEdit';
	}
}
