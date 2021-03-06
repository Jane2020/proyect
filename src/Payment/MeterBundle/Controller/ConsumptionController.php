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
use Payment\MeterBundle\Entity\DateToList;

class ConsumptionController extends Controller
{
	const LIMIT_PAGINATOR = 20;
	const LIMIT_LIST = 38;
	/**
	 * @Template()
	 * @Secure(roles="ROLE_OPERATOR")
	 */
	public function listConsumptionAction(Request $request)
	{
		if(!$this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->isEnabled('date_start_consumption','date_end_consumption',$this->get('security.context')->isGranted('ROLE_ADMIN')))
		{
			throw $this->createNotFoundException('Esta funcionalidad esta desabilitada, por favor consulte con el Administrador del sistema.');
		}
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
	 * Secure(roles="ROLE_OPERATOR")
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
	 * Secure(roles="ROLE_OPERATOR")
	 */
	public function editConsumptionAction(Request $request)
	{
		$title = "Editar";
		$consumptionId = $request->request->get('cid', 0);
		if (is_array($consumptionId)) {
			$consumptionId = $consumptionId[0];
		}
	
		$em = $this->getDoctrine()->getManager();
		$accountId = 0;
		if ($consumptionId > 0)
		{
			$consumption = $em->getRepository('PaymentDataAccessBundle:Consumption')->find($consumptionId);
			$date = $consumption->getReadDate()->format('Y-m-d');
			$dates = explode('-',$date);
			$consumption->setReadDate($dates[1]);
			$accountId = $consumption->getAccount()->getId();			
			if($consumption->getIsDeleted())
			{
				throw new AccessDeniedException();
			}			
			
		}
		else 
		{
			$consumption = new Consumption();
			$title = "Crear";
		}
		$rol = true;
		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) 
		{
			$rol = false;
		}
		
		$consumptionForm = $this->createForm(new ConsumptionEditType($em,$rol,$accountId), $consumption);
	
		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				
				$consumptionForm->bind($request);
				$consumptionExist = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findconsumptionByNameToList($consumption->getAccount(), 0, 5, true, false);
				
				$date = $consumption->getReadDate();
				$date1 = date('Y').'-'.$date;
				if(($date == 12) && (date('Y-m') > $date1))
				{
					$year = date('Y');
					$year = $year -1;
					$date1 = $year.'-'.$date1;
				}

				$conReview = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->reviewConsumptionByAccount($consumption->getAccount(), $date1, $consumption->getId());
				if(((!$consumptionExist) || ($consumptionId > 0)) and (!$conReview))
				{	
					$consumptionAnt = $em->getRepository('PaymentDataAccessBundle:Consumption')->findPrevious($consumption);
					$meterAnt = 0;
					if($consumptionAnt)	
					{
						if(is_array($consumptionAnt)) 
						{
							$consumptionAnt = $consumptionAnt[0];
						}
						$consumption->setMeterPreviousReading($consumptionAnt);
						$meterAnt = $consumptionAnt->getMeterCurrentReading();
					}
					if ($consumption->getMeterCurrentReading() == 0)
					{
						$consumption->setMeterCurrentReading($meterAnt);
					}
					$value = $consumption->getMeterCurrentReading() - $meterAnt;
					if($value >= 0)
					{
						if ($consumptionForm->isValid())
						{	
							$consumption->setConsumptionValue($value);
							
							$date = $date1.'-25';
							$consumption->setReadDate(new \DateTime($date));
							if($consumptionId == 0)
							{
								$consumption->setSystemDate(new \DateTime());
							}							
												
							$user = $this->get('security.context')->getToken()->getUser();	
							$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
							$consumption->setSystemUser($userData);
							$consumption->setIsDeleted(0);
							$em->persist($consumption);
							$em->flush();
							$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
			
							return $this->redirect($this->generateUrl('_listConsumption'));
						}						
					}
					$this->get('session')->getFlashBag()->add('message', 'La lectura ingresada, es menor a la lectura anterior del medidor que es: '.$meterAnt.'. Por favor corrija su ingreso.');
				} else {
					$this->get('session')->getFlashBag()->add('message', 'La lectura para la cuenta '.$consumption->getAccount()->getAccountNumber().' ya se encuentra registrada.');
				}
			}
		}
		return array('form' => $consumptionForm->createView(), 'title' => $title, 'cid'=>$consumptionId,'rol' => $rol);
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_OPERATOR")
	 */
	public function readConsumptionAction(Request $request)
	{
		return array();
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_OPERATOR")
	 */
	public function selectToReadConsumptionAction(Request $request)
	{
		$date = new DateToList();
		$form = $this->createFormBuilder($date)
		->add('mounth', 'choice', array(
			    'choices'   => array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'),
			    'required'  => true,
				'empty_value' => 'Seleccione...',
			))
		->add('year', 'choice', array(
			    'choices'   => array('2013' => '2013', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020'),
			    'required'  => true,
				'empty_value' => 'Seleccione...',
			))
		->getForm();
		
		return array('form' => $form->createView());
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_OPERATOR")
	 */
	public function listToReadConsumptionAction(Request $request)
	{
		$form = $request->get('form');
		$limit = self::LIMIT_LIST;
		$accounts = $this->getDoctrine()->getEntityManager()->getRepository('PaymentDataAccessBundle:Account')->findByIsActive(1,array('accountNumber' => 'ASC'));
		$month = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
		$date = $month[$form['mounth']].' '.$form['year'];
		$accounts = $this->getListToRead($accounts, $limit);
		return array('accounts' => $accounts, 'date' => $date,'limit' => $limit * 2);
	}
	/**
	 * @Secure(roles="ROLE_OPERATOR")
	 */

	private function getListToRead($account, $limit)
	{
		$i = 1;
		$k = 1;
		$init = 0;
		$sum = 1;
		$result = array();
		foreach ($account as $item)
		{
			$result[$i] = $item;	
			$i = $i + 2;
			if($k == $limit)
			{	
				$sum++;				
				if ($sum == 3)
				{
					$init = $init + 2;
					$init = $limit * $init;
					$sum = 1;
				}
				$i = $init + $sum;
				$k = 0;
												
			}
			$k++;			
		}
		$cont = count($account);
		for ($j = $k; $j <= $limit; $j++)
		{
			$result[$i] = 'null';
			$i = $i + 2;
		}
		ksort($result);

		return $result;
	}
}
