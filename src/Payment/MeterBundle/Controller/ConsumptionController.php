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
use Payment\DataAccessBundle\Entity\Consumption;
use Payment\MeterBundle\Form\Type\ConsumptionEditType;

class ConsumptionController extends Controller
{
	const LIMIT_PAGINATOR = 20;
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
	
		$rol = true;
		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$rol = false;
    	}		

		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findconsumptionByNameToList($consumptionSelect, $offsetItem, $limit, $rol);
		$total = $total[0][1];
		$consumption = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findconsumptionByNameToList($consumptionSelect, $offsetItem, $limit, $rol, false);
		$paginator = new Paginator($consumptionForm->getName(), $total, $offset, $limit);
	
		return array('form' => $consumptionForm->createView(), 'limit' => $limit, 'total' => $total, 'consumption' => $consumption, 'paginator' => $paginator);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deleteConsumptionAction(Request $request)
	{
		$consumptionId = $request->request->get('cid', 0);
		if (is_array($consumptionId)) {
			$consumptionId = $consumptionId[0];
		}
		$em = $this->getDoctrine()->getManager();	
		$consumption = $em->getRepository('PaymentDataAccessBundle:Consumption')->find($consumptionId);
		
		if (!$consumption) {
			$message = "El item seleccionado no ha podido ser encontrado.";
		} else {
			$remark = $request->request->get('remark');
			$consumption->setIsDeleted(1);
			$consumption->setDescription($remark);
			$user = $this->get('security.context')->getToken()->getUser();	
			$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
			$consumption->setChangeUser($userData);
			$consumption->setSystemDate(new \DateTime());
			$em->flush();	
			$message = "El item ha sido Eliminado &eacute;xitosamente.";
		}	
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listConsumption'));
	
	}
	
	
	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editConsumptionAction(Request $request)
	{
		$title = "Editar";
		$consumptionId = $request->request->get('cid', 0);
		if (is_array($consumptionId)) {
			$consumptionId = $consumptionId[0];
		}
	
		$em = $this->getDoctrine()->getManager();
		if ($consumptionId > 0)
		{
			$consumption = $em->getRepository('PaymentDataAccessBundle:Consumption')->find($consumptionId);
			$consumption->setReadDate($consumption->getReadDate()->format('Y-m-d'));
			
		} else {
			$consumption = new Consumption();
			$title = "Crear";
		}
	
		$consumptionForm = $this->createForm(new ConsumptionEditType(), $consumption);
	
		if ($request->getMethod() == 'POST') {
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$consumptionForm->bind($request);
				if ($consumptionForm->isValid())
				{
					$consumption->setStartDate(new \DateTime($consumption->getStartDate()));
					$consumption->setEndDate(new \DateTime($consumption->getEndDate()));
					$user = $this->get('security.context')->getToken()->getUser();
	
					$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
					$consumption->setSystemUser($userData);
					$em->persist($consumption);
					$em->flush();
					$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
	
					return $this->redirect($this->generateUrl('_listconsumption'));
				}
			}
		}
		return array('form' => $consumptionForm->createView(), 'title' => $title, 'cid'=>$consumptionId);
	}
	
}
