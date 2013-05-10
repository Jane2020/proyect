<?php

namespace Payment\PaymentBundle\Controller;

use Payment\PaymentBundle\Form\Type\PaymentEditType;

use Payment\DataAccessBundle\Entity\Payment;
use Payment\PaymentBundle\Form\Type\PaymentSearchType;
use Payment\PaymentBundle\Entity\PaymentSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class PaymentController extends Controller
{
	const LIMIT_PAGINATOR = 15;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listPaymentAction(Request $request)
	{
		$paymentEntity = new PaymentSearch();
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;
		$paymentText = null;
	
		$paymentForm = $this->createForm(new PaymentSearchType(), $paymentEntity);
		if ($request->getMethod() == 'POST')
		{
			$paymentForm->bind($request);
			$datas = $paymentForm->getData();
			if ($paymentForm->isValid()) 
			{
				$paymentText = $datas->getName();
				$offset = $datas->getOffset();
				$limit = $datas->getLimit();
			}
		}
		$offsetItem = $offset;
		if ($offsetItem > 0) 
		{
			$offsetItem = $offsetItem - 1;
		}
		$offsetItem = $offsetItem * $limit;
		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Payment')->findPaymentByNameToList($paymentText, $offsetItem, $limit);
		$total = $total[0][1];
		$payment = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Payment')->findPaymentByNameToList($paymentText, $offsetItem, $limit, false);
		$paginator = new Paginator($paymentForm->getName(), $total, $offset, $limit);
		return array('form' => $paymentForm->createView(), 'limit' => $limit, 'total' => $total, 'payment' => $payment, 'paginator' => $paginator);
	}
	
	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editPaymentAction(Request $request)
	{
		$title = "Editar";
		$paymentId = $request->request->get('cid', 0);
		if (is_array($paymentId))
		{
			$paymentId = $paymentId[0];
		}
			
		$em = $this->getDoctrine()->getManager();
		if ($paymentId > 0)
		{
			$payment = $em->getRepository('PaymentDataAccessBundle:Payment')->find($paymentId);
			if ($payment->getPaymentDate())
			{
				$payment->setPaymentDate($payment->getPaymentDate()->format('Y-m-d'));
			}
			$payment->setMemberId($payment->getMember()->getId());
			$payment->setMemberName($payment->getMember()->getName().' '.$payment->getMember()->getLastname());
		} 
		else 
		{
			$payment = new Payment();
			$title = "Crear";
		}
		$paymentForm = $this->createForm(new PaymentEditType(), $payment);
		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$paymentForm->bind($request);
				if ($paymentForm->isValid())
				{
					$payment->setPaymentDate(new \DateTime($payment->getPaymentDate()));
					$user = $this->get('security.context')->getToken()->getUser();
					$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
					$member = $em->getRepository('PaymentDataAccessBundle:Member')->find($payment->getMemberId());
					$payment->setSystemUser($userData);
					$payment->setMember($member);					
					$em->persist($payment);
					$em->flush();
					$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
	
					return $this->redirect($this->generateUrl('_listPayment'));
				}
			}
		}
		return array('form' => $paymentForm->createView(), 'title' => $title, 'cid'=>$paymentId);
	}

	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deleteManagerialAction(Request $request)
	{
		$managerialId = $request->request->get('cid', 0);
		if (is_array($managerialId)) 
		{
			$managerialId = $managerialId[0];
		}
		$em = $this->getDoctrine()->getManager();
		$managerial = $em->getRepository('PaymentDataAccessBundle:Managerial')->find($managerialId);
		
		if (!$managerial) 
		{
			$message = "El item seleccionado no ha podido ser encontrado.";
		}
		else 
		{
			$em->remove($managerial);
			$em->flush();
			$message = "El item ha sido Eliminado &eacute;xitosamente.";			
		}
		
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listManagerial'));
	}
}