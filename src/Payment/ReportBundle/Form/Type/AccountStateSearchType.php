<?php
namespace Payment\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class AccountStateSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
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
		
		$builder->add('mounthStart', 'choice', array(
				'choices'   => array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'),
				'required'  => false,
				'label' => 'Mes Inicio',
				'empty_value' => 'Seleccione...',
				));
		$builder->add('mounthEnd', 'choice', array(
				'choices'   => array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'),
				'required'  => false,
				'label' => 'Mes Fin',
				'empty_value' => 'Seleccione...',
		));
		
		$builder->add('yearAccount', 'choice', array('choices'=>array(2013=>2013,2014=>2014,2015=>2015,2016=>2016,2017=>2017,2018=>2018,2019=>2019,2020=>2020), 'label' => 'Año:'));		
	}
	
	
	public function getName()
	{
		return 'accounStateSearch';
	}
}