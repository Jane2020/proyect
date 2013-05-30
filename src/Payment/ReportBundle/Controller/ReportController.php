<?php

namespace Payment\ReportBundle\Controller;

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
    	$total = $em->getRepository('PaymentDataAccessBundle:Payment')->findMemberAssistanceToList($memberText, $paymentType, $startDate, $endDate, $offsetItem, $limit);
    	$total = $total[0][1];
    	$memberAssistance = $em->getRepository('PaymentDataAccessBundle:Payment')->findMemberAssistanceToList($memberText, $paymentType, $startDate, $endDate,$offsetItem, $limit, false);
    	$paginator = new Paginator($memberAssitanceForm->getName(), $total, $offset, $limit);
    	return array('form' => $memberAssitanceForm->createView(), 'limit' => $limit, 'total' => $total, 'memberAssistance' => $memberAssistance, 'paginator' => $paginator);    
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
    	$to = null;
    	$from = null;
    	
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
    	$total = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($this, $orderOption, $to, $from, $offsetItem, $limit);
    	$total = $total[0]['total'];
    	$members = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($this, $orderOption, $to, $from, $offsetItem, $limit, false);
    	$paginator = new Paginator($memberForm->getName(), $total, $offset, $limit);
    	return array('form' => $memberForm->createView(), 'limit' => $limit, 'total' => $total, 'members' => $members, 'paginator' => $paginator);
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
    	
    	$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpensesByFilters($startDate, $endDate, $offsetItem, $limit);
    	$total = $total[0][1];
    	$expense = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpensesByFilters($startDate, $endDate, $offsetItem, $limit, false);
    	$paginator = new Paginator($expenseForm->getName(), $total, $offset, $limit);
    	return array('form' => $expenseForm->createView(), 'limit' => $limit, 'total' => $total, 'expense' => $expense, 'paginator' => $paginator);    	 
    }
}