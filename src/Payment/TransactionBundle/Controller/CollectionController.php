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
		if(!$this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Parameter')->isEnabled('date_start_collection','date_end_collection',$this->get('security.context')->isGranted('ROLE_ADMIN')))
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
		if ($request->getMethod() == 'POST') {
			$form->bind($request);			
			if ($form->isValid()) {
				$datas = $form->getData();
				$account = $datas->getAccount();
				$user = $this->get('security.context')->getToken()->getUser();
				$items = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->getItemsToCollection($user,$account);	
				$band = true;
				$contItems = count($items);		
				$accountId = $account->getId();	
			}
		}
		return array('form' => $form->createView(), 'band' => $band, 'account' => $account, 'items' => $items, 'contItems' => $contItems, 'accountId' => $accountId);
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_TREASURER")
	 */
	public function printCollectionAction($accountId)
	{
		$account = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->find($accountId);
		$user = $this->get('security.context')->getToken()->getUser();
		$items = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->getItemsToCollection($user,$account,true);
		$contItems = count($items);
		return array('account' => $account, 'items' => $items, 'contItems' => $contItems);
	}
}
