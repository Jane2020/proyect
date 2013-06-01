<?php
namespace Payment\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ExpensivesSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('startDate','text',  array('label'=>'Fecha de Inicio:', 'required'=>false, 'max_length'=>10));
		$builder->add('endDate','text',  array('label'=>'Fecha de Fin:', 'required'=>false, 'max_length'=>10));
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'expensivesSearch';
	}
}