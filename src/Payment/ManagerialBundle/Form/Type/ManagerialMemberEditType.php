<?php
namespace Payment\ManagerialBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ManagerialMemberEditType extends AbstractType
{
	private $em;
	
	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('memberId','hidden');
		$builder->add('memberName','text',  array('label'=>'Nombre del Miembro:', 'required'=>false, 'max_length'=>128));
		$builder->add('charge', 'entity',
				array(
						'class' => 'PaymentDataAccessBundle:Charge',
						'query_builder' => $this->getQueryBuilderCharge(),
						'label' => 'Cargo',
						'empty_value' => 'Seleccione',
						'required' => false,
						'property' => 'name',
				)
		);
		
		$builder->add('managerial', 'entity',
				array(
						'class' => 'PaymentDataAccessBundle:Managerial',
						'query_builder' => $this->getQueryBuilderManagerial(),
						'label' => 'Directiva:',
						'empty_value' => 'Seleccione',
						'required' => false,
						'property' => 'name',
				)
		);
		$builder->add('isActive','checkbox',  array('label'=>'Activo: ', 'required'=>false,));
	}

	public function getName()
	{
		return 'managerialMemberEdit';
	}
	
	private function getQueryBuilderCharge()
	{
		$qb = $this->em->createQueryBuilder('p');
		$qb->add('select', 'p');
		$qb->add('from', 'PaymentDataAccessBundle:Charge p');
		$qb->andwhere($qb->expr()->eq('p.isActive', '1'));
		$qb->orderBy('p.name', 'ASC');
		return $qb;
	}
	
	private function getQueryBuilderManagerial()
	{
		$qb = $this->em->createQueryBuilder('p');
		$qb->add('select', 'p');
		$qb->add('from', 'PaymentDataAccessBundle:Managerial p');
		$qb->andwhere($qb->expr()->eq('p.isActive', '1'));
		$qb->orderBy('p.name', 'ASC');
		return $qb;
	}
}