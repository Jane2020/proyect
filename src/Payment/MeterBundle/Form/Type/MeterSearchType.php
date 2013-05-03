<?php
namespace Payment\MeterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MeterSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('accountNumber', 'text', array('label'=>'Número de Cuenta:', 'required'=>false, 'max_length'=>20));
		$builder->add('offset','hidden');		
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'meterSearch';
	}
}
