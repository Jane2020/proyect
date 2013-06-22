<?php
namespace Payment\TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\TransactionBundle\Entity\CollectionSearch;
use Payment\TransactionBundle\Form\Type\CollectionSearchType;

class CollectionController extends Controller
{
	/**
	 * @Template()
	 * @Secure(roles="ROLE_TREASURER")
	 */
	public function itemsCollectionAction(Request $request)
	{
		if(!$this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->isEnabled('date_start_collection','date_end_collection',$this->get('security.context')->isGranted('ROLE_ADMIN'), true))
		{
			throw $this->createNotFoundException('Esta funcionalidad esta desabilitada, por favor consulte con el Administrador del sistema.');
		} 
		$collectionSearch = new CollectionSearch();	
		$account = null;
		$items = null;
		$band = false;	
		$contItems = 0;
		$accountId = 0;
		$form = $this->createForm(new CollectionSearchType(), $collectionSearch);
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);			
			if ($form->isValid()) 
			{
				$datas = $form->getData();
				$account = $datas->getAccount();
				$user = $this->get('security.context')->getToken()->getUser();
				$result = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->getItemsToCollection($user,$account);
				$items = $result['items'];
				$band = true;
				$contItems = count($items);		
				$accountId = $account->getId();	
			}
		}
		$month = array('02' => 'Enero', '03' => 'Febrero', '04' => 'Marzo', '05' => 'Abril', '06' => 'Mayo', '07' => 'Junio', '08' => 'Julio', '09' => 'Agosto', '10' => 'Septiembre', '11' => 'Octubre', '12' => 'Noviembre', '01' => 'Diciembre');
		$date = $month[date('m')].' '.date('Y');
		return array('form' => $form->createView(), 'band' => $band, 'account' => $account, 'items' => $items, 'contItems' => $contItems, 'accountId' => $accountId, 'dateFac' => $date);
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_TREASURER")
	 */
	public function printCollectionAction($accountId)
	{
		$account = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->find($accountId);
		$user = $this->get('security.context')->getToken()->getUser();
		$result = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->getItemsToCollection($user,$account,true);
		$items = $result['items'];
		$contItems = count($items);
		$month = array('02' => 'Enero', '03' => 'Febrero', '04' => 'Marzo', '05' => 'Abril', '06' => 'Mayo', '07' => 'Junio', '08' => 'Julio', '09' => 'Agosto', '10' => 'Septiembre', '11' => 'Octubre', '12' => 'Noviembre', '01' => 'Diciembre');
		$date = $month[date('m')].' '.date('Y');
		$factNumber = str_pad($result['transaction'], 8, "0", STR_PAD_LEFT);		
		return array('account' => $account, 'items' => $items, 'contItems' => $contItems, 'dateFac' => $date,'factNumber' => $factNumber);
	}
}
