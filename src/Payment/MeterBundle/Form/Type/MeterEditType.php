<?php
namespace Payment\MeterBundle\Form\Type;

use Payment\DataAccessBundle\Entity\Member;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MeterEditType extends AbstractType
{
	
	private $em;
	
	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('memberId','hidden');
		$builder->add('accountNumber','text',  array('label'=>'Número de Cuenta:', 'required'=>false, 'max_length'=>32));
		$builder->add('meterNumber','text',  array('label'=>'Número de Medidor:', 'required'=>false, 'max_length'=>64));
		$builder->add('isActive','checkbox',  array('label'=>'Activo: ', 'required'=>false,));
		$builder->add('sewerage','checkbox',  array('label'=>'Alcantarillado: ', 'required'=>false,));
		$builder->add('memberName','text',  array('label'=>'Nombre del Miembro:', 'required'=>false, 'max_length'=>128));
		$builder->add('accountType', 'entity',
				array(
						'class' => 'PaymentDataAccessBundle:AccountType',
						'query_builder' => $this->getQueryBuilder(),
						'label' => 'Tipo de Cuenta',
						'empty_value' => 'Seleccione',
						'required' => false,
						'property' => 'name',
				)
		);
	}

	public function getName()
	{
		return 'meterEdit';
	}
	
	private function getQueryBuilder()
	{
		$qb = $this->em->createQueryBuilder('p');
		$qb->add('select', 'p');
		$qb->add('from', 'PaymentDataAccessBundle:AccountType p');
		$qb->andwhere($qb->expr()->eq('p.isActive', '1'));
		$qb->orderBy('p.name', 'ASC');
		return $qb;
	}
}