<?php
namespace Payment\TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\TransactionBundle\Entity\ExpenseSearch;
use Payment\TransactionBundle\Form\Type\ExpenseSearchType;
use Payment\DataAccessBundle\Entity\Transaction;

class ExpenseController extends Controller
{
   const LIMIT_PAGINATOR = 20;
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listExpenseAction(Request $request)
	{
		$expenseEntity = new ExpenseSearch();
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;
		$expenseDate = null;
		$expenseName = null;
		$expenseRuc = null;
	
		$expenseForm = $this->createForm(new ExpenseSearchType(), $expenseEntity);
		if ($request->getMethod() == 'POST') {
			$expenseForm->bind($request);
			$datas = $expenseForm->getData();
			if ($expenseForm->isValid()) {
				$expenseDate = $datas->getExpenseDate();
				$expenseName = $datas->getExpenseName();
				$expenseRuc = $datas->getExpenseRuc(); 
				$offset = $datas->getOffset();
				$limit = $datas->getLimit();
			}
		}
		$offsetItem = $offset;
		if ($offsetItem > 0) {
			$offsetItem = $offsetItem - 1;
		}
		$offsetItem = $offsetItem * $limit;

		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpenseByFilters($expenseDate,$expenseName,$expenseRuc, $offsetItem, $limit);
		$total = $total[0][1];
		$expense = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Expense')->findExpenseByFilters($expenseDate,$expenseName,$expenseRuc, $offsetItem, $limit, false);
		$paginator = new Paginator($expenseForm->getName(), $total, $offset, $limit);
	
		return array('form' => $expenseForm->createView(), 'limit' => $limit, 'total' => $total, 'expense' => $expense, 'paginator' => $paginator);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deleteExpenseAction(Request $request)
	{
		$expenseId = $request->request->get('cid', 0);
		if (is_array($expenseId)) {
			$expenseId = $expenseId[0];
		}
		$em = $this->getDoctrine()->getManager();
		$expense = $em->getRepository('PaymentDataAccessBundle:Expense')->find($expenseId);
	
		if (!$expense) {
			$message = "El item seleccionado no ha podido ser encontrado.";
		} else {
			$remark = $request->request->get('remark');
				
			$transactionAnt = $expense->getTransaction();
			$user = $this->get('security.context')->getToken()->getUser();
			$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
			$transaction = new Transaction();
				
			$transaction->setManagerial($transactionAnt->getManagerial());
			$transaction->setTotalValue($transactionAnt->getTotalValue());
			$transaction->setTransactionType($transactionAnt->getTransactionType());
			$transaction->setSystemDate(new \DateTime());
			$transaction->setSystemUser($userData);
			$transaction->setTranscationReverse($transactionAnt);
			$em->persist($transaction);
			$em->flush();
				
			$transactionAnt->setTranscationReverse($transaction);
			$em->persist($transactionAnt);
			$em->flush();
				
			$expense->setIsDeleted(1);
			$expense->setDescription($remark);
			$expense->setChangeUser($userData);
			$expense->setSystemDate(new \DateTime());
			$em->persist($expense);
			$em->flush();
			$message = "El item ha sido Eliminado &eacute;xitosamente.";
		}
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listExpense'));
	
	}
}
