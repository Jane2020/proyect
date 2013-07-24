<?php
namespace Payment\TransactionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ExpenseSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('expenseDate', 'text', array('label'=>'Fecha de Expedición:', 'required'=>false, 'max_length'=>10));
		$builder->add('expenseName', 'text', array('label'=>'Nombre:', 'required'=>false, 'max_length'=>64));
		$builder->add('expenseRuc', 'text', array('label'=>'Factura:', 'required'=>false, 'max_length'=>13));
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'expenseSearch';
	}
}
