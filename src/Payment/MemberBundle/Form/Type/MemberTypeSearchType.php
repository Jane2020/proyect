<?php
namespace Payment\MemberBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberTypeSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array('label'=>'Nombre:', 'required'=>false, 'max_length'=>64));
		$builder->add('lastname', 'text', array('label'=>'Apellido:', 'required'=>false, 'max_length'=>64));
		$builder->add('documentNumber', 'text', array('label'=>'Cédula de Identidad:', 'required'=>false, 'max_length'=>10));
		$builder->add('offset','hidden');		
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'memberTypeSearch';
	}
}
