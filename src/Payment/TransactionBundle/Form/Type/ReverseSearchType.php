<?php
namespace Payment\TransactionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ReverseSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('number', 'text', array('label' => '# Factura: ','required' => false));
		$builder->add('offset','hidden');
		$builder->add('limit','hidden');
	}
	
	public function getName()
	{
		return 'reverseSearch';
	}
}
