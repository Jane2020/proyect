<?php

namespace Payment\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Payment\MemberBundle\Form\Type\MemberTypeSearchType;
use Payment\MemberBundle\Entity\MemberTypeSearch;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\DataAccessBundle\Entity\Member;


class DefaultController extends Controller
{
	const LIMIT_PAGINATOR = 10;
	
	/**
	 * @Template()
	 *
	 */
	public function welcomeAction()
	{
		$message = null;
		$user = $this->get('security.context');
		if ($user->isGranted('ROLE_USER'))
		{
			return array();
		}
	
		return $this->redirect($this->generateUrl('_login'));
	}

	/**
	 * @Template()
	 *
	 */
	public function modalAction(Request $request)
	{
		$memberTypeEntity = new MemberTypeSearch();
		$limit = self::LIMIT_PAGINATOR;
		$formName = $request->get('formName');
		
		$offset = 0;
		$memberName = null;
		$memberLastName = null;
		$memberDocumentNumber = null;
		$memberTypeForm = $this	->createForm(new MemberTypeSearchType(), $memberTypeEntity);
		
		if ($request->getMethod() == 'POST')
		{
			$memberTypeForm->bind($request);
			$datas = $memberTypeForm->getData();
			if ($memberTypeForm->isValid())
			{
				$memberName = $datas->getName();
				$memberLastName = $datas->getLastname();
				$memberDocumentNumber = $datas->getDocumentNumber();
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
		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Member')->findMemberByParametersToList($memberName, $memberLastName, $memberDocumentNumber, false, $offsetItem, $limit);
		$total = $total[0][1];
		$member = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Member')->findMemberByParametersToList($memberName, $memberLastName,$memberDocumentNumber, false, $offsetItem, $limit, false);
		$paginator = new Paginator($memberTypeForm->getName(), $total, $offset,	$limit);
		return array('form' => $memberTypeForm->createView(), 'limit' => $limit, 'total' => $total, 'member' => $member, 'paginator' => $paginator, 'formName' => $formName);
	}
}