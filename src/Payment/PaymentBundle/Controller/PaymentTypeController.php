<?php

namespace Payment\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\DataAccessBundle\Entity\PaymentType;
use Payment\PaymentBundle\Form\Type\PaymentTypeEditType;
use Payment\PaymentBundle\Form\Type\PaymentTypeSearchType;
use Payment\PaymentBundle\Entity\PaymentTypeSearch;


class PaymentTypeController extends Controller
{
	const LIMIT_PAGINATOR = 15;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listPaymentTypeAction(Request $request)
	{
		$paymentTypeEntity = new PaymentTypeSearch();
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;
		$paymentTypeText = null;
	
		$paymentTypeForm = $this->createForm(new PaymentTypeSearchType(), $paymentTypeEntity);
		if ($request->getMethod() == 'POST')
		{
			$paymentTypeForm->bind($request);
			$datas = $paymentTypeForm->getData();
			if ($paymentTypeForm->isValid()) 
			{
				$paymentTypeText = $datas->getName();
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
		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Payment')->findPaymentTypeByNameToList($paymentTypeText, $offsetItem, $limit);
		$total = $total[0][1];
		$paymentType = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Payment')->findPaymentTypeByNameToList($paymentTypeText, $offsetItem, $limit, false);
		$paginator = new Paginator($paymentTypeForm->getName(), $total, $offset, $limit);
		return array('form' => $paymentTypeForm->createView(), 'limit' => $limit, 'total' => $total, 'paymentType' => $paymentType, 'paginator' => $paginator);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deletePaymentTypeAction(Request $request)
	{
		return $this->actionToPaymentType($request,false);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function activePaymentTypeAction(Request $request)
	{
		return $this->actionToPaymentType($request);
	}
	
	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editPaymentTypeAction(Request $request)
	{
		$title = "Editar";
		$paymentTypeId = $request->request->get('cid', 0);
		if (is_array($paymentTypeId)) {
			$paymentTypeId = $paymentTypeId[0];
		}
		 
		$em = $this->getDoctrine()->getManager();
		if ($paymentTypeId > 0)
		{
			$paymentType = $em->getRepository('PaymentDataAccessBundle:PaymentType')->find($paymentTypeId);
		} 
		else 
		{
			$paymentType = new PaymentType();
			$title = "Crear";
		}
		 
		$paymentTypeForm = $this->createForm(new PaymentTypeEditType(), $paymentType);
		 
		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$paymentTypeForm->bind($request);
				if ($paymentTypeForm->isValid())
				{
					$paymentTypeType = $em->getRepository('PaymentDataAccessBundle:PaymentTypeType')->find($paymentType->getPaymentTypeType()->getId());
					$paymentType->setPaymentTypeType($paymentTypeType);
					$em->persist($paymentType);
					$em->flush();
					$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
	
					return $this->redirect($this->generateUrl('_listPaymentType'));
				}
			}
		}
		return array('form' => $paymentTypeForm->createView(), 'title' => $title, 'cid'=>$paymentTypeId);
	}
	
	private function actionToPaymentType(Request $request, $active = true)
	{
		$paymentTypeId = $request->request->get('cid', 0);
		if (is_array($paymentTypeId))
		{
			$paymentTypeId = $paymentTypeId[0];
		}
		 
		$em = $this->getDoctrine()->getManager();
		$paymentType = $em->getRepository('PaymentDataAccessBundle:paymentType')->find($paymentTypeId);
	
		if (!$paymentType) 
		{
			$message = "El item seleccionado no ha podido ser encontrado.";
		}
		else 
		{
			if ($active)
			{
				$publish = $request->request->get('publish');
				$paymentType->setIsActive($publish);
				$em->flush();
				if ($publish == 1) 
				{
					$message = "El item ha sido Activado &eacute;xitosamente.";
				}
				else 
				{
					$message = "El item ha sido Desactivado &eacute;xitosamente.";
				}
			} else {
				$em->remove($paymentType);
				$em->flush();
				$message = "El item ha sido Eliminado &eacute;xitosamente.";
			}
		}
	
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listPaymentType'));
	}
}