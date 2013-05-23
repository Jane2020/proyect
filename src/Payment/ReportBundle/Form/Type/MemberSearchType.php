<?php
namespace Payment\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class MemberSearchType extends AbstractType
{
	private $em;
	
	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('order', 'choice', array(
				'choices' => array('1' => 'Nombre de Miembro', '2' => 'Cuenta'), 
				'label' => 'Orden:'
		));
		$builder->add('to', 'choice', array(
						'choices'   => $this->getQueryBuilder(),
						'label' => 'Desde:',
						'empty_value' => 'Seleccione',
						'required' => false						
				)
		);
		
		$builder->add('to', 'choice', array(
				'choices'   => $this->getQueryBuilder(),
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
	
	private function getQueryBuilder()
	{
		$member = null;
		$result = $em->createQuery("SELECT @curRank := @curRank + 1 AS rank
									FROM member m, (SELECT @curRank := 0) r
								 where m.isActive = 1");
		print_r($result);
		exit();
		foreach ($result as $item)
		{
			$member[$item] = $item;
		}
		return $member;
	}
}