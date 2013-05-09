<?php
namespace Payment\MeterBundle\Form\Type;

use Payment\DataAccessBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsumptionEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('account', 'entity', array(
				'class' => 'PaymentDataAccessBundle:Account',
				'query_builder' => function(EntityRepository $er) {
					return $er->createQueryBuilder('a')
					->where('a.isActive = 1')->orderBy('a.accountNumber', 'ASC');
				},
				'property' => 'accountNumber',
				'empty_value' => '',
				'label' => '# Conexión',
				'required' => false,
		));
		$builder->add('meterCurrentReading','text',  array('label'=>'Lectura de Medidor', 'required'=>false, 'max_length'=>11));
		$builder->add('description','textarea',  array('label'=>'Número de Medidor:', 'required'=>false, 'max_length'=>512));
		$builder->add('readDate','text',  array('label'=>'Fecha de Lectura:', 'required'=>false, 'max_length'=>10));
	}

	public function getName()
	{
		return 'consumptionEdit';
	}
}