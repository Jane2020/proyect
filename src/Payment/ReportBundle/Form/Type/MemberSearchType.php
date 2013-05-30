<?php
namespace Payment\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class MemberSearchType extends AbstractType
{
	private $numberMember;
	
	public function __construct($numberMember)
	{
		$this->numberMember = $numberMember;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('order', 'choice', array(
				'choices' => array('1' => 'Nombre de Miembro', '2' => 'Cuenta'), 
				'label' => 'Orden:'
		));
		$builder->add('to', 'choice', array(
						'choices'   => $this->numberMember,
						'label' => 'Desde:',
						'empty_value' => 'Seleccione',
						'required' => false						
				)
		);
		
		$builder->add('from', 'choice', array(
				'choices'   => $this->numberMember,
				'label' => 'Hasta:',
				'empty_value' => 'Seleccione',
				'required' => false		
		)
		);
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'memberSearch';
	}
}