<?php
namespace Payment\PaymentBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('memberId','hidden');
		$builder->add('paymentType', 'entity',
				array(
						'class' => 'PaymentDataAccessBundle:PaymentType',
						'label' => 'Tipo de Pago:',
						'empty_value' => 'Seleccione',
						'required' => false,
						'property' => 'name',
				)
		);
		$builder->add('cost','text',  array('label'=>'Valor del Pago:', 'required'=>false, 'max_length'=>8));
		$builder->add('paymentDate','text',  array('label'=>'Fecha de Pago:', 'required'=>false, 'max_length'=>10));
		$builder->add('memberName','text',  array('label'=>'Nombre del Miembro:', 'required'=>false, 'max_length'=>128));		
	}

	public function getName()
	{
		return 'paymentEdit';
	}
}
