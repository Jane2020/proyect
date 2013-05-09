<?php
namespace Payment\PaymentBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentTypeEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('name','text',  array('label'=>'Nombre:', 'required'=>false, 'max_length'=>64));
		$builder->add('description','textarea',  array('label'=>'Descripción:', 'required'=>false, 'max_length'=>64));
		$builder->add('cost','text',  array('label'=>'Valor de Multa:', 'required'=>false, 'max_length'=>8));
		$builder->add('isActive','checkbox',  array('label'=>'Activo: ', 'required'=>false,));
	}

	public function getName()
	{
		return 'paymentTypeEdit';
	}
}
