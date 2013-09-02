<?php

namespace Payment\ReportBundle\Controller;

use Payment\ReportBundle\Form\Type\AccountStateSearchType;

use Payment\ReportBundle\Entity\AccountStateSearch;

use Payment\ReportBundle\Form\Type\CollectionReportSearchType;
use Payment\ReportBundle\Entity\CollectionSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\ReportBundle\Entity\MemberAssistanceSearch;
use Payment\ReportBundle\Form\Type\MemberAssistanceSearchType;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Payment\ReportBundle\Form\Type\MemberSearchType;
use Payment\ReportBundle\Entity\MemberSearch;
use Payment\ReportBundle\Entity\ExpensesSearch;
use Payment\ReportBundle\Form\Type\ExpensivesSearchType;


class ReportController extends Controller
{
	const LIMIT_PAGINATOR = 10;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_SECRETARY")
	 */
    public function reportMemberAssistanceAction(Request $request)
    {
    	$memberAssistanceEntity = new MemberAssistanceSearch();
    	$limit = self::LIMIT_PAGINATOR;
    	$offset = 0;
    	$memberText = null;
    	$paymentType = null;
    	$startDate = null;
    	$endDate = null;
    	$em = $this->getDoctrine()->getManager();
    	
    	$memberAssitanceForm = $this->createForm(new MemberAssistanceSearchType($em), $memberAssistanceEntity);
    	if ($request->getMethod() == 'POST') 
    	{
    		$memberAssitanceForm->bind($request);
    		$datas = $memberAssitanceForm->getData();
    		if ($memberAssitanceForm->isValid()) 
    		{
    			$memberText = $datas->getName();
    			$paymentType = $datas->getPaymentType();
    			$startDate = $datas->getStartDate(); 
    			$endDate = $datas->getEndDate();
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
    	$limit_paginator = $this->container->getParameter('limit_paginator');
    	$total = $em->getRepository('PaymentDataAccessBundle:Payment')->findMemberAssistanceToList($memberText, $paymentType, $startDate, $endDate, $offsetItem, $limit);
    	$total = $total[0][1];
    	$memberAssistance = $em->getRepository('PaymentDataAccessBundle:Payment')->findMemberAssistanceToList($memberText, $paymentType, $startDate, $endDate,$offsetItem, $limit, false);
    	$paginator = new Paginator($memberAssitanceForm->getName(), $total, $offset, $limit);
    	
    	$valueRecidivism = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->findByKey('recidivism_cost');
    	$valueRecidivism = $valueRecidivism[0]->getValue();
    	return array('form' => $memberAssitanceForm->createView(), 'limit' => $limit, 'total' => $total, 'memberAssistance' => $memberAssistance, 'paginator' => $paginator, 'limit_paginator' => $limit_paginator,'recidivism' => $valueRecidivism);    
    }
    
	/**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportMemberAction(Request $request)
    {
    	$memberEntity = new MemberSearch();
    	$limit = self::LIMIT_PAGINATOR;
    	$offset = 0;
    	$orderOption = null;
    	$from = null;
    	$to = null;
    	
    	$em = $this->getDoctrine()->getManager();
    	$form = $request->get('memberSearch');
    	$option = $form['order'];
    	if (is_null($option))
    	{
    		$option = 1;
    	}
    	$numberMember = $this->getNumberMember($option);
    	$memberForm = $this->createForm(new MemberSearchType($numberMember), $memberEntity);
    	if ($request->getMethod() == 'POST')
    	{
    		$memberForm->bind($request);
    		$datas = $memberForm->getData();
    		if ($memberForm->isValid())
    		{
    			$orderOption = $datas->getOrder();
    			$to = $datas->getTo();
    			$from = $datas->getFrom();
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
    	$limit_paginator = $this->container->getParameter('limit_paginator');
    	$total = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($this, $orderOption, $to, $from, $offsetItem, $limit);
    	$total = $total[0]['total'];
    	$members = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($this, $orderOption, $to, $from, $offsetItem, $limit, false);
    	$paginator = new Paginator($memberForm->getName(), $total, $offset, $limit);
    	return array('form' => $memberForm->createView(), 'limit' => $limit, 'total' => $total, 'members' => $members, 'orderOption'=>$orderOption, 'paginator' => $paginator, 'limit_paginator' => $limit_paginator);
    }
    
    
    private function getNumberMember($option)
    {
    	$member = array();
    	$conec = $this->get('database_connection');
    	//Member
    	if ($option == 1)
    	{
	    	$result =  $conec->fetchAll("SELECT @curRank := @curRank + 1 AS rank FROM member, (SELECT @curRank := 0) r where member.is_active = 1");
	    	foreach ($result as $item)
	    	{
	    		$member[$item['rank']] = $item['rank'];
	    	}
    	}   
    	else
    	{
    		//Account
    		$result =  $conec->fetchAll("SELECT @curRank := @curRank + 1 AS rank FROM account, (SELECT @curRank := 0) r where account.is_active = 1");
    		foreach ($result as $item)
    		{
    			$member[$item['rank']] = $item['rank'];
    		}
    	}
    	return $member;
    }
    
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function loadAjaxSelectAction(Request $request)
    {
    	$option = (int)$request->get('option1');    	    
    	$option1 = (int)$request->get('op');    	
    	
    	$id = 'memberSearch_to';
    	$name = 'memberSearch[to]';
    	$action = '';
    	
    	if($option1 == 2)
    	{
    		$id = 'memberSearch_from';
    		$name = 'memberSearch[from]';
    		$action = 'onclick="javascript:elimineColor();"';
    	}
    	
    	$numberMember = $this->getNumberMember($option);
    	$html = '<select name="'.$name.'" id="'.$id.'" '.$action.'><option value="">Seleccione</option>';
    	foreach ($numberMember as $item)
    	{
    		$html .= '<option value="'.$item.'">'.$item.'</option>';
    	}
    	$html .= '</select>';
    	echo($html);
    	exit();
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportExpensesAction(Request $request)
    {
    	$expenseEntity = new ExpensesSearch();
    	$startDate = null;
    	$endDate = null;
    	$limit = self::LIMIT_PAGINATOR;
    	$offset = 0;    	
    	$expenseForm = $this->createForm(new ExpensivesSearchType(), $expenseEntity);
    	if ($request->getMethod() == 'POST') 
    	{
    		$expenseForm->bind($request);
    		$datas = $expenseForm->getData();
    		if ($expenseForm->isValid()) 
    		{
    			$startDate = $datas->getStartDate();
    			$endDate = $datas->getEndDate();
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
    	$limit_paginator = $this->container->getParameter('limit_paginator');
    	$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpensesByFilters($startDate, $endDate, $offsetItem, $limit);
    	$total = $total[0][1];
    	$expense = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpensesByFilters($startDate, $endDate, $offsetItem, $limit, false);
    	$paginator = new Paginator($expenseForm->getName(), $total, $offset, $limit);
    	return array('form' => $expenseForm->createView(), 'limit' => $limit, 'total' => $total, 'expense' => $expense, 'paginator' => $paginator, 'limit_paginator' => $limit_paginator);    	 
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportCollectionAction(Request $request)
    {
    	$collectionEntity = new CollectionSearch();
    	$startDate = null;
    	$endDate = null;
    	$limit = self::LIMIT_PAGINATOR;
    	$offset = 0;
    	$collectionForm = $this->createForm(new CollectionReportSearchType(), $collectionEntity);
    	if ($request->getMethod() == 'POST')
    	{
    		$collectionForm->bind($request);
    		$datas = $collectionForm->getData();
    		if ($collectionForm->isValid())
    		{
    			$startDate = $datas->getStartDate();
    			$endDate = $datas->getEndDate();
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
    	$limit_paginator = $this->container->getParameter('limit_paginator');
    	$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->findCollectionByFilters($this, $startDate, $endDate, $offsetItem, $limit);
    	$total = $total[0]['total'];
    	$collection = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->findCollectionByFilters($this, $startDate, $endDate, $offsetItem, $limit, false);
    	$paginator = new Paginator($collectionForm->getName(), $total, $offset, $limit);
    	return array('form' => $collectionForm->createView(), 'limit' => $limit, 'total' => $total, 'collection' => $collection, 'paginator' => $paginator, 'limit_paginator' => $limit_paginator);
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportDetailCollectionAction(Request $request)
    {
    	$transactionId = $request->get('id');
    	$collections = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Income')->findByTransaction($transactionId);
    	$account = $collections[0]->getConsumption()->getAccount();
    	$transaction = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->find($transactionId);
    	$date = $transaction->getSystemDate();
    	$year = $date->format('Y');
    	$date = $date->format('m');
    	$month = array('02' => 'Enero', '03' => 'Febrero', '04' => 'Marzo', '05' => 'Abril', '06' => 'Mayo', '07' => 'Junio', '08' => 'Julio', '09' => 'Agosto', '10' => 'Septiembre', '11' => 'Octubre', '12' => 'Noviembre', '01' => 'Diciembre');
    	$date = $month[$date].' '.$year;
    	$factNumber = str_pad($transactionId, 8, "0", STR_PAD_LEFT);
    	$dateImp = $transaction->getSystemDate()->format('d-m-Y H:i:s');
    	return array ('collections' => $collections, 'date' => $date, 'account' => $account,'factNumber' => $factNumber,'dateImp' => $dateImp, 'transactionId' => $transactionId);
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function printCollectionDetailNewlyAction(Request $request)
    {
    	$transactionId = $request->get('id');
    	$collections = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Income')->findByTransaction($transactionId);
    	$account = $collections[0]->getConsumption()->getAccount();
    	$transaction = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->find($transactionId);
    	$date = $transaction->getSystemDate();
    	$year = $date->format('Y');
    	$date = $date->format('m');
    	$month = array('02' => 'Enero', '03' => 'Febrero', '04' => 'Marzo', '05' => 'Abril', '06' => 'Mayo', '07' => 'Junio', '08' => 'Julio', '09' => 'Agosto', '10' => 'Septiembre', '11' => 'Octubre', '12' => 'Noviembre', '01' => 'Diciembre');
    	$date = $month[$date].' '.$year;
    	$factNumber = str_pad($transactionId, 8, "0", STR_PAD_LEFT);
    	$dateImp = $transaction->getSystemDate()->format('d-m-Y H:i:s');
    	return array ('collections' => $collections, 'date' => $date, 'account' => $account,'factNumber' => $factNumber,'dateImp' => $dateImp);
    }
     
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportListAction()
    {
    	 return array();
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function reportAccountStateAction(Request $request)
    {
    	$accountStateEntity = new AccountStateSearch();
    	$accountStateForm = $this->createForm(new AccountStateSearchType(), $accountStateEntity);
    	$stateAccount = null;
    	$account = null;
    	$accountId = 0;
    	$year = 0;
    	$parameters = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->findAll();
    	$basicConsumption = $parameters[6]->getValue();
    	if ($request->getMethod() == 'POST')
    	{
    		$accountStateForm->bind($request);
    		$datas = $accountStateForm->getData();
    		if ($accountStateForm->isValid())
    		{
    			$account = $datas->getAccount();
    			$year = $datas->getYearAccount();
    			$mounthStart = $datas->getMounthStart();
    			$mounthEnd = $datas->getMounthEnd();
    			if ($account)
    			{
    				$consumptions = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Income')->getStateAccount($account,$year); 			
    				$stateAccount = $this->getItems($consumptions, $basicConsumption,$mounthStart,$mounthEnd,$year);
	   				$accountId = $account->getId();
    			}
    		}    		
    	}
    	return array ('form' => $accountStateForm->createView(),'stateAccount' => $stateAccount, 'account'=>$account, 'basicConsumption' => $basicConsumption, 'accountId' => $accountId, 'year' => $year);    
    }    
    
    /**
     * @Template()
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function printAccountStateAction($accountId, $year)
    {
    	$account = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->find($accountId);
    	$parameters = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->findAll();
    	$basicConsumption = $parameters[6]->getValue();
    	$consumptions = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Income')->getStateAccount($account,$year);
    	$stateAccount = $this->getItems($consumptions, $basicConsumption);
    		
    	return array ('stateAccount' => $stateAccount, 'account'=>$account, 'basicConsumption' => $basicConsumption);
    }
    
    
    private function getItems($consumptions, $basic, $mountStart, $mountEnd, $year)
    {
    	$items = array();
    	$account = null;
    	$i = -1;
    	$transaction_id = 0;
    	$month = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
    	foreach ($consumptions as $item)
    	{
    		$transaction = $item->getTransaction();
    		if (($transaction->getId() != $transaction_id))
    		{
    			if($i >= 0)
    			{
    				$result['other'] = $sum + $sumFine;
    				$items[$i] = $result;
    			}    			
    			$transaction_id = $transaction->getId();
    			$i++;
    			$result = array('excedent' => 0, 'excedentCost' => 0, 'other' => 0);
    			$sumFine = 0; $sum = 0;
    			$result['date'] = $transaction->getSystemDate()->format('Y-m-d');    			
    			$result['basic'] = $basic;
    			
    		} 
    		$consumption = $item->getConsumption();
    		$type = $item->getIncomeType()->getId();
    		
    		if($consumption)
    		{
    			
    			switch ($type)
    			{
    				case 1: 
    						if(isset($result['present']))
    						{
    							$result['other'] = $sum ;
    							$items[$i] = $result;
    							$i++;
    							$result = array('excedent' => 0, 'excedentCost' => 0, 'other' => 0);
    							$result['date'] = $transaction->getSystemDate()->format('Y-m-d');
    							$result['basic'] = $basic;
    							$sum = 0;
    						}
    						
    						$result['present'] = $consumption->getMeterCurrentReading();
    						$result['basicCost'] = $item->getBasicServiceUnitCost();
    						if($consumption->getMeterPreviousReading())
    						{
    							$result['previous'] = $consumption->getMeterPreviousReading()->getMeterCurrentReading();
    						} else {
    							$result['previous'] = $consumption->getMeterCurrentReading();
    						}
    						$date = $consumption->getReadDate();
    						$result['month'] = $month[$date->format('m')].' '.$date->format('Y');
    						$result['dates'] = $date->format('m').'-'.$date->format('Y');
    					break;
    				case 2: $sum = $sum + ($item->getAmount() * $item->getBasicServiceUnitCost());
    						break;
    				case 3: $result['excedent'] = $item->getAmount();
    						 $result['excedentCost'] = $item->getBasicServiceUnitCost();
    					break;
    				case 6: $sum = $sum + ($item->getAmount() * $item->getBasicServiceUnitCost());
    					break;
    			}    			
    		}    		
    		$payment = $item->getPayment();
    		
    		if($payment)
    		{
    			switch ($type)
    			{
    				case 4: $sumFine = $sumFine + ($item->getAmount() * $item->getBasicServiceUnitCost());
    				break;
    				case 5: $sumFine = $sumFine + ($item->getAmount() * $item->getBasicServiceUnitCost());				
    			}
    		}   		
    	}

    	$result['other'] = $sum + $sumFine;
    	$items[$i] = $result;
    	
    	$result = array();
    	
    	foreach ($items as $item)
    	{
    		if(($item['dates'] >= $mountStart.'-'.$year)&&($item['dates'] <= $mountEnd.'-'.$year))
    		{    			
    			$result[] = $item;
    		}
    	}
    	
    	
    	return $result;
    }
    
    private function getStateAccount($consumption, $parameter)
    {
    	$i = 0;
    	foreach ($consumption as $item)
    	{
    		$aditionalCost = 0;
    		if ($i == 0)
    		{	
    			$val = $item->getMeterCurrentReading();    			
    		}
    		else
    		{
    			$date = $item->getSystemDate();
    			$paymentDate = $date->format('d-m-Y');
	    		$date = $date->format('m');
	    		$month = array('02' => 'Enero', '03' => 'Febrero', '04' => 'Marzo', '05' => 'Abril', '06' => 'Mayo', '07' => 'Junio', '08' => 'Julio', '09' => 'Agosto', '10' => 'Septiembre', '11' => 'Octubre', '12' => 'Noviembre', '01' => 'Diciembre');
	    		$date = $month[$date];
	    		$basicCost = $parameter[3]->getValue();
	    		$excess = $item->getConsumptionValue() - $parameter[6]->getValue();
	    		if ($excess > 0)
	    		{
	    			$excessCost = $excess * $parameter[7]->getValue();	    			
	    		} 
	    		else
	    		{
	    			$excess = 0;
	    			$excessCost = 0;
	    		}
	    		$totalUnit = $basicCost + $excessCost;
	    		$totalPayment = 0;
	    		$payment = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Payment')->findBy(array('account'=>$item->getAccount()));
	    		if ($payment)
	    		{
	    			
	    			foreach ($payment as $paymentValue)
	    			{
	    				if ($paymentValue->getIsRecidivism())
	    				{
	    					$recidivism = 2;    						
	    				}
	    				else
	    				{
	    					$recidivism = 1;
	    				}
	    				$totalPayment = $totalPayment + ($paymentValue->getCost() * $recidivism);
	    			}	    			
	    		}
	    		if ($item->getAccount()->getSewerage())
	    		{
	    			$aditionalCost +=  $parameter[4]->getValue() * $item->getAccount()->getSewerage();
	    		}
	    		$total = $totalUnit +$aditionalCost + $totalPayment;
	    		$stateAccount = array ('date' =>$date, 'meterCurrentReading'=> $item->getMeterCurrentReading(), 'meterBeforeReading' => $val, 'consumptionValue' =>$item->getConsumptionValue(), 'basicConsumption' => $parameter[6]->getValue(),'excess' =>$excess, 'basicCost' => $basicCost, 'excessCost' =>$excessCost, 'totalUnit' => $totalUnit, 'aditionalCost' => $aditionalCost, 'total' =>$total,'paymentDate' => $paymentDate);
	    		$val = $item->getMeterCurrentReading();    		
    		}  
    		if ($i != 0)
    		{
    			$stateAccounts[] = $stateAccount;
    		}
    		$i++;
    	}
    	
    	
    	
    	return($stateAccounts);    	  	
    }
}