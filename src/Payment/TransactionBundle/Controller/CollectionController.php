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
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function itemsCollectionAction(Request $request)
	{
		$collectionSearch = new CollectionSearch();	
		$account = null;
		$items = null;
		$band = false;	
		$form = $this->createForm(new CollectionSearchType(), $collectionSearch);
		if ($request->getMethod() == 'POST') {
			$form->bind($request);			
			if ($form->isValid()) {
				$datas = $form->getData();
				$account = $datas->getAccount();
				$items = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Transaction')->getItemsToCollections($account);	
				$band = true;
			}
		}
		return array('form' => $form->createView(), 'band' => $band, 'account' => $account, 'items' => $items);
	}
}
