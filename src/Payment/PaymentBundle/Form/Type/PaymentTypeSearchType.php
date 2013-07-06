<?php
namespace Payment\PaymentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentTypeSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array('label'=>utf8_encode('Nombre del Tipo de Pago:'), 'required'=>false, 'max_length'=>64));
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'paymentTypeSearch';
	}
}
