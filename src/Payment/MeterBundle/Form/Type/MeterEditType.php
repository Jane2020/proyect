<?php
namespace Payment\MeterBundle\Form\Type;

use Payment\DataAccessBundle\Entity\Member;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MeterEditType extends AbstractType
{
	
	private $em;
	private $sewerageArray;
	
	public function __construct($entityManager, $sewerageArray)
	{
		$this->em = $entityManager;
		$this->sewerageArray = $sewerageArray;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('memberId','hidden');
		$builder->add('accountNumber','text',  array('label'=>'Número de Cuenta:', 'required'=>false, 'max_length'=>32));
		$builder->add('meterNumber','text',  array('label'=>'Número de Medidor:', 'required'=>false, 'max_length'=>64));
		$builder->add('isActive','checkbox',  array('label'=>'Activo: ', 'required'=>false,));
		$builder->add('sewerage', 'choice', array(
				'choices'   => $this->sewerageArray,
				'label' => 'Alcantarillado:',
				'empty_value' => '0',
				'required' => false
		)
		);
		
		$builder->add('memberName','text',  array('label'=>'Nombre del Miembro:', 'required'=>false, 'max_length'=>512));
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