<?php
namespace Payment\TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\TransactionBundle\Form\Type\ReverseSearchType;
use Payment\TransactionBundle\Entity\ReverseSearch;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;

class ReverseController extends Controller
{
	const LIMIT_PAGINATOR = 20;
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function reverseAction(Request $request)
	{
		$reverseSearch = new ReverseSearch();	
		$number = null;		
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;

		
		$form = $this->createForm(new ReverseSearchType(), $reverseSearch);
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);			
			if ($form->isValid()) 
			{
				$datas = $form->getData();
				$number = $datas->getNumber();
				$offset = $datas->getOffset();
				$limit = $datas->getLimit();
			}
		}
		
		$offsetItem = $offset;
		if ($offsetItem > 0) {
			$offsetItem = $offsetItem - 1;
		}
		$offsetItem = $offsetItem * $limit;		

		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->findTransactionByNumber($this,$number, $offsetItem, $limit);
		$total = $total[0]['total'];

		$transactions = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->findTransactionByNumber($this,$number, $offsetItem, $limit, false);
		$paginator = new Paginator($form->getName(), $total, $offset, $limit);
	
		return array('form' => $form->createView(), 'limit' => $limit, 'total' => $total, 'transactions' => $transactions, 'paginator' => $paginator);
	
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function reverseExecAction(Request $request)
	{
		$transactionId = $request->request->get('cid', 0);
		if (is_array($transactionId)) {
			$transactionId = $transactionId[0];
		}
		$em = $this->getDoctrine()->getManager();
		$transaction = $em->getRepository('PaymentDataAccessBundle:Transaction')->find($transactionId);
	
		if (!$transaction) {
			$message = "El item seleccionado no ha podido ser encontrado.";
		} else {
			$user = $this->get('security.context')->getToken()->getUser();
			if($em->getRepository('PaymentDataAccessBundle:Transaction')->reverseByTransaction($transaction, $user))
			{
				$message = "La transacci&oacute;n ha sido Reversada &eacute;xitosamente.";
			} else {
				$message = "La transacción no pudo ser Reversada. Por favor intentelo mas tarde.";
			}
		}
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listReverse'));	
	}
}
