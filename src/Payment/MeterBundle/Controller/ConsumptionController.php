<?php
namespace Payment\MeterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\MeterBundle\Entity\ConsumptionSearch;
use Payment\MeterBundle\Form\Type\ConsumptionSearchType;

class ConsumptionController extends Controller
{
	const LIMIT_PAGINATOR = 10;
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listConsumptionAction(Request $request)
	{
		$consumptionEntity = new ConsumptionSearch();
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;
		$consumptionSelect = null;
	
		$consumptionForm = $this->createForm(new ConsumptionSearchType(), $consumptionEntity);
		if ($request->getMethod() == 'POST') {
			$consumptionForm->bind($request);
			$datas = $consumptionForm->getData();
			if ($consumptionForm->isValid()) {
				$consumptionSelect = $datas->getAccount();
				$offset = $datas->getOffset();
				$limit = $datas->getLimit();
			}
		}
		$offsetItem = $offset;
		if ($offsetItem > 0) {
			$offsetItem = $offsetItem - 1;
		}
		$offsetItem = $offsetItem * $limit;
		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findconsumptionByNameToList($consumptionSelect, $offsetItem, $limit);
		$total = $total[0][1];
		$consumption = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findconsumptionByNameToList($consumptionSelect, $offsetItem, $limit, false);
		$paginator = new Paginator($consumptionForm->getName(), $total, $offset, $limit);
	
		return array('form' => $consumptionForm->createView(), 'limit' => $limit, 'total' => $total, 'consumption' => $consumption, 'paginator' => $paginator);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deleteManagerialAction(Request $request)
	{
		return $this->actionToManagerial($request,false);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function activeManagerialAction(Request $request)
	{
		return $this->actionToManagerial($request);
	}
	
	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editManagerialAction(Request $request)
	{
		$title = "Editar";
		$managerialId = $request->request->get('cid', 0);
		if (is_array($managerialId)) {
			$managerialId = $managerialId[0];
		}
	
		$em = $this->getDoctrine()->getManager();
		if ($managerialId > 0)
		{
			$managerial = $em->getRepository('PaymentDataAccessBundle:Managerial')->find($managerialId);
			$managerial->setStartDate($managerial->getStartDate()->format('Y-m-d'));
			$managerial->setEndDate($managerial->getEndDate()->format('Y-m-d'));
		} else {
			$managerial = new Managerial();
			$title = "Crear";
		}
	
		$managerialForm = $this->createForm(new ManagerialEditType(), $managerial);
	
		if ($request->getMethod() == 'POST') {
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$managerialForm->bind($request);
				if ($managerialForm->isValid())
				{
					$managerial->setStartDate(new \DateTime($managerial->getStartDate()));
					$managerial->setEndDate(new \DateTime($managerial->getEndDate()));
					$user = $this->get('security.context')->getToken()->getUser();
	
					$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
					$managerial->setSystemUser($userData);
					$em->persist($managerial);
					$em->flush();
					$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
	
					return $this->redirect($this->generateUrl('_listManagerial'));
				}
			}
		}
		return array('form' => $managerialForm->createView(), 'title' => $title, 'cid'=>$managerialId);
	}
	
	private function actionToManagerial(Request $request, $active = true)
	{
		$managerialId = $request->request->get('cid', 0);
		if (is_array($managerialId)) {
			$managerialId = $managerialId[0];
		}
	
		$em = $this->getDoctrine()->getManager();
		$managerial = $em->getRepository('PaymentDataAccessBundle:Managerial')->find($managerialId);
	
		if (!$managerial) {
			$message = "El item seleccionado no ha podido ser encontrado.";
		} else {
			if ($active)
			{
				$publish = $request->request->get('publish');
				$managerial->setIsActive($publish);
				$em->flush();
				if ($publish == 1) {
					$message = "El item ha sido Activado &eacute;xitosamente.";
				} else {
					$message = "El item ha sido Desactivado &eacute;xitosamente.";
				}
			} else {
				$em->remove($managerial);
				$em->flush();
				$message = "El item ha sido Eliminado &eacute;xitosamente.";
			}
		}
	
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listManagerial'));
	}
	}