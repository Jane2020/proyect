<?php
namespace Payment\MeterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ConsumptionSearchType extends AbstractType
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
    			'label' => '# Conexión'
	));
		
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'consumptionSearch';
	}
}
