<?php
namespace Payment\MemberBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('documentNumber','text',  array('label'=>'Cédula de Identidad:', 'required'=>false, 'max_length'=>10));
		$builder->add('name','text',  array('label'=>'Nombres:', 'required'=>false, 'max_length'=>128));
		$builder->add('lastname','text',  array('label'=>'Apellidos:', 'required'=>false, 'max_length'=>128));
		$builder->add('birthDate','text',  array('label'=>'Fecha de Nacimiento:', 'required'=>false, 'max_length'=>10));
		$builder->add('address','text',  array('label'=>'Dirección:', 'required'=>false, 'max_length'=>256));
		$builder->add('email','text',  array('label'=>'E-mail:', 'required'=>false, 'max_length'=>256));
		$builder->add('phone','text',  array('label'=>'Teléfono:', 'required'=>false, 'max_length'=>9));
		$builder->add('celularPhone','text',  array('label'=>'Celular:', 'required'=>false, 'max_length'=>10));
		$builder->add('isActive','checkbox',  array('label'=>'Activo: ', 'required'=>false,));
	}

	public function getName()
	{
		return 'memberEdit';
	}
}