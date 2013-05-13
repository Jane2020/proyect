<?php
namespace Payment\TransactionBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ExpenseEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('expenseName','text',  array('label'=>'Nombre:', 'required'=>false, 'max_length'=>512));
		$builder->add('expenseRuc','text',  array('label'=>'Ruc:', 'required'=>false, 'max_length'=>13));
		$builder->add('expenseDate','text',  array('label'=>'Fecha Expedición:', 'required'=>false, 'max_length'=>10));
		$builder->add('expenseNumber','text',  array('label'=>'Número de Factura:', 'required'=>false, 'max_length'=>32));
		$builder->add('expenseIva','text',  array('label'=>'Valor Iva:', 'required'=>false, 'max_length'=>8));
		$builder->add('expenseAddress','text',  array('label'=>'Dirección:', 'required'=>false, 'max_length'=>512));
		$builder->add('expenseValue','text',  array('label'=>'Valor:', 'required'=>false, 'max_length'=>8));
		$builder->add('expensePhone','text',  array('label'=>'Teléfono:', 'required'=>false, 'max_length'=>10));
		$builder->add('expenseDescription','textarea',  array('label'=>'Descripción:', 'required'=>false, 'max_length'=>512));
	}

	public function getName()
	{
		return 'expenseEdit';
	}
}
