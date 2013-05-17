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
	public function editPaymentAction($id, Request $request)
	{
		$title = "Editar";
		$paymentId = $request->request->get('cid', 0);
		if (is_array($paymentId))
		{
			$paymentId = $paymentId[0];
		}
			
		$em = $this->getDoctrine()->getManager();
		$accountId = 0;
		if ($paymentId > 0)
		{
			$payment = $em->getRepository('PaymentDataAccessBundle:Payment')->find($paymentId);
			$id = $payment->getPaymentType()->getPaymentTypeType()->getId();
			if ($payment->getPaymentDate())
			{
				$payment->setPaymentDate($payment->getPaymentDate()->format('Y-m-d'));
			}
			//Cuenta - Rubro
			if ($id == 2)
			{
				$accountId = $payment->getAccount()->getId();								
			}
			//Miembro -Inasistencia
			if ($id == 1)
			{	
				$payment->setMemberId($payment->getMember()->getId());
				$payment->setMemberName($payment->getMember()->getName().' '.$payment->getMember()->getLastname());
			}				
		} 
		else 
		{
			$payment = new Payment();
			$title = "Crear";			
		}
		
		$paymentForm = $this->createForm(new PaymentEditType($em, $accountId, $id), $payment);
		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$paymentForm->bind($request);
				if ($paymentForm->isValid())
				{
					if ($payment->getMemberId())
					{
						$validation = $this->validationParameter($payment->getMemberId());
					}
					else	
					{
						$validation = $this->validationParameter($payment->getAccount());
					}
					if ($validation)
					{
						$payment->setPaymentDate(new \DateTime($payment->getPaymentDate()));
						$user = $this->get('security.context')->getToken()->getUser();
						$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
						if ($id == 1)
						{
							$member = $em->getRepository('PaymentDataAccessBundle:Member')->find($payment->getMemberId());
							$payment->setMember($member);
						}
						$payment->setSystemUser($userData);
						$payment->setIsDeleted(0);				
						$em->persist($payment);
						$em->flush();
						$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
						return $this->redirect($this->generateUrl('_listPayment'));
					}
					else
					{
						if($id == 1)
						{
							$this->get('session')->getFlashBag()->add('message', 'Por favor ingrese el nombre del miembro.');
						}
						else
						{
							$this->get('session')->getFlashBag()->add('message', 'Por favor ingrese el número de conexión.');
						}
					}
				}
			}
		}
		return array('form' => $paymentForm->createView(), 'title' => $title, 'cid'=>$paymentId, 'id' => $id);
	}
    
	/**
	 * Función que valida su el campo es nulo.
	 */
	private function validationParameter($parameter)
	{
		if ($parameter)
		{
			return true;			
		}
		return false;
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deletePaymentAction(Request $request)
	{
		$paymentId = $request->request->get('cid', 0);
		if (is_array($paymentId)) 
		{
			$paymentId = $paymentId[0];
		}
		$em = $this->getDoctrine()->getManager();
		$payment = $em->getRepository('PaymentDataAccessBundle:Payment')->find($paymentId);
	
		if (!$payment) 
		{
			$message = "El item seleccionado no ha podido ser encontrado.";
		} 
		else 
		{
			$remark = $request->request->get('remark');
			$payment->setIsDeleted(1);
			$payment->setDescription($remark);
			$user = $this->get('security.context')->getToken()->getUser();
			$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
			$payment->setChangeUser($userData);
			$payment->setPaymentDate(new \DateTime());
			$em->flush();
			$message = "El item ha sido Eliminado &eacute;xitosamente.";
		}
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listPayment'));	
	}
}