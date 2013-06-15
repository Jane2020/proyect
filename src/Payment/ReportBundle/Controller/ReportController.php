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
	 * @Secure(roles="ROLE_ADMIN")
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
    	return array('form' => $memberAssitanceForm->createView(), 'limit' => $limit, 'total' => $total, 'memberAssistance' => $memberAssistance, 'paginator' => $paginator, 'limit_paginator' => $limit_paginator);    
    }
    
	/**
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
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
    	$numberMember = $this->getNumberMember();
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
    
    
    private function getNumberMember()
    {
    	$member = array();
    	$conec = $this->get('database_connection');
    	$result =  $conec->fetchAll("SELECT @curRank := @curRank + 1 AS rank FROM member, (SELECT @curRank := 0) r where member.is_active = 1");
    	foreach ($result as $item)
    	{
    		$member[$item['rank']] = $item['rank'];
    	}    	
    	return $member;
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
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
     * @Secure(roles="ROLE_ADMIN")
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
     * @Secure(roles="ROLE_ADMIN")
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
    	return array ('collections' => $collections, 'date' => $date, 'account' => $account);
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function reportListAction()
    {
    	 return array();
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function reportAccountStateAction(Request $request)
    {
    	$accountStateEntity = new AccountStateSearch();
    	$accountStateForm = $this->createForm(new AccountStateSearchType(), $accountStateEntity);
    	$stateAccount = null;
    	$account = null;
    	$parameters = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->findAll();
    	$basicConsumption = $parameters[6]->getValue();
    	if ($request->getMethod() == 'POST')
    	{
    		$accountStateForm->bind($request);
    		$datas = $accountStateForm->getData();
    		if ($accountStateForm->isValid())
    		{
    			$account = $datas->getAccount();
    			if ($account)
    			{
    				$consumption = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Consumption')->findByConsumption($account->getId());
	   				$account = $consumption[0]->getAccount();
	   				$stateAccount = $this->getStateAccount($consumption, $parameters);
    			}
    		}    		
    	}
    	return array ('form' => $accountStateForm->createView(),'stateAccount' => $stateAccount, 'account'=>$account, 'basicConsumption'=>$basicConsumption);    
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