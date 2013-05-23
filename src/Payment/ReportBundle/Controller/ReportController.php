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
use Payment\TransactionBundle\Entity\ExpenseSearch;
use Payment\TransactionBundle\Form\Type\ExpenseSearchType;


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
    	$memberText = null;
    	$em = $this->getDoctrine()->getManager();
    	$memberForm = $this->createForm(new MemberSearchType($em), $memberEntity);
    	if ($request->getMethod() == 'POST')
    	{
    		$memberForm->bind($request);
    		$datas = $memberForm->getData();
    		if ($memberForm->isValid())
    		{
    			$memberText = $datas->getName();
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
    	$total = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($memberText, $offsetItem, $limit);
    	$total = $total[0][1];
    	$members = $em->getRepository('PaymentDataAccessBundle:Member')->findMemberByParameterToList($memberText, $offsetItem, $limit, false);
    	$paginator = new Paginator($memberForm->getName(), $total, $offset, $limit);
    	return array('form' => $memberForm->createView(), 'limit' => $limit, 'total' => $total, 'members' => $members, 'paginator' => $paginator);
    }
    
    /**
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function reportExpensesAndCollectionsAction(Request $request)
    {
    	$expenseEntity = new ExpenseSearch();
    	$limit = self::LIMIT_PAGINATOR;
    	$offset = 0;
    	$expenseDate = null;
    	$expenseName = null;
    	$expenseRuc = null;
    	$expenseForm = $this->createForm(new ExpenseSearchType(), $expenseEntity);
    	if ($request->getMethod() == 'POST') 
    	{
    		$expenseForm->bind($request);
    		$datas = $expenseForm->getData();
    		if ($expenseForm->isValid()) 
    		{
    			$expenseDate = $datas->getExpenseDate();
    			$expenseName = $datas->getExpenseName();
    			$expenseRuc = $datas->getExpenseRuc();
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
    	
    	$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpenseByFilters($expenseDate,$expenseName,$expenseRuc, $offsetItem, $limit);
    	$total = $total[0][1];
    	$expense = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpenseByFilters($expenseDate,$expenseName,$expenseRuc, $offsetItem, $limit, false);
    	$paginator = new Paginator($expenseForm->getName(), $total, $offset, $limit);
    	return array('form' => $expenseForm->createView(), 'limit' => $limit, 'total' => $total, 'expense' => $expense, 'paginator' => $paginator);    	 
    }
}