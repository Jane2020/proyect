<?php
namespace Payment\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class MemberAssistanceSearchType extends AbstractType
{
	private $em;
	
	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array('label'=>utf8_encode('Nombre:'), 'required'=>false, 'max_length'=>64));
		$builder->add('paymentType', 'entity',
				array(
						'class' => 'PaymentDataAccessBundle:PaymentType',
						'query_builder' => $this->getQueryBuilder(),
						'label' => 'Tipo:',
						'empty_value' => 'Todos',
						'required' => false,
						'property' => 'name',
				)
		);
		$builder->add('startDate','text',  array('label'=>'Fecha de Inicio:', 'required'=>false, 'max_length'=>10));
		$builder->add('endDate','text',  array('label'=>'Fecha de Fin:', 'required'=>false, 'max_length'=>10));
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'memberAssistanceSearch';
	}
	
	private function getQueryBuilder()
	{
		$qb = $this->em->createQueryBuilder('p');
		$qb->add('select', 'p');
		$qb->add('from', 'PaymentDataAccessBundle:PaymentType p');
		$qb->andwhere($qb->expr()->eq('p.isActive', '1'));
		$qb->orderBy('p.name', 'ASC');
		return $qb;
	}
}
