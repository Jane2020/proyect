<?php

namespace Payment\MemberBundle\Controller;

use Payment\MemberBundle\Form\Type\MemberTypeSearchType;
use Payment\MemberBundle\Form\Type\MemberEditType;
use Payment\MemberBundle\Entity\MemberTypeSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\DataAccessBundle\Entity\Member;

class MemberController extends Controller 
{
	const LIMIT_PAGINATOR = 10;

	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listMemberAction(Request $request)
	{
		$memberTypeEntity = new MemberTypeSearch();
		$limit = self::LIMIT_PAGINATOR;
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
		if ($offsetItem > 0) {
			$offsetItem = $offsetItem - 1;
		}
		$offsetItem = $offsetItem * $limit;
		$total = $this->getDoctrine()->getManager()
				->getRepository('PaymentDataAccessBundle:Member')
				->findMemberByParametersToList($memberName, $memberLastName,
						$memberDocumentNumber, $offsetItem, $limit);
		$total = $total[0][1];
		$member = $this->getDoctrine()->getManager()
				->getRepository('PaymentDataAccessBundle:Member')
				->findMemberByParametersToList($memberName, $memberLastName,
						$memberDocumentNumber, $offsetItem, $limit, false);
		$paginator = new Paginator($memberTypeForm->getName(), $total, $offset,
				$limit);
		return array('form' => $memberTypeForm->createView(),
				'limit' => $limit, 'total' => $total, 'member' => $member,
				'paginator' => $paginator);
	}

	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function deleteMemberAction(Request $request) {
		return $this->actionToMember($request, false);
	}

	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function activeMemberAction(Request $request) {
		return $this->actionToMember($request);
	}

	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editMemberAction(Request $request) {
		$title = "Edición";
		$memberId = $request->request->get('cid', 0);
		if (is_array($memberId)) {
			$memberId = $memberId[0];
		}
		$em = $this->getDoctrine()->getManager();
		if ($memberId > 0) {
			$member = $em->getRepository('PaymentDataAccessBundle:Member')
					->find($memberId);
		} else {
			$member = new Member();
			$title = "Creación";
		}

		$memberForm = $this->createForm(new MemberEditType(), $member);

		if ($request->getMethod() == 'POST') {
			$band = $request->request->get('band', 0);
			if ($band != 0) {
				$memberForm->bind($request);
				if ($memberForm->isValid()) {
					$em->persist($member);
					$em->flush();
					$this->get('session')->getFlashBag()
							->add('message',
									'El Item ha sido almacenado &eacute;xitosamente.');
					return $this->redirect($this->generateUrl('_listMember'));
				}
			}
		}
		return array('form' => $memberForm->createView(), 'title' => $title,
				'cid' => $memberId);
	}

	private function actionToMember(Request $request, $active = true) {
		$memberId = $request->request->get('cid', 0);
		if (is_array($memberId)) {
			$memberId = $memberId[0];
		}

		$em = $this->getDoctrine()->getManager();
		$member = $em->getRepository('PaymentDataAccessBundle:Member')
				->find($memberId);

		if (!$member) {
			$message = "El item seleccionado no ha podido ser encontrado.";
		} else {
			if ($active) {
				$publish = $request->request->get('publish');
				$member->setIsActive($publish);
				$em->flush();
				if ($publish == 1) {
					$message = "El item ha sido Activado &eacute;xitosamente.";
				} else {
					$message = "El item ha sido Desactivado &eacute;xitosamente.";
				}
			} else {
				$em->remove($member);
				$em->flush();
				$message = "El item ha sido Eliminado &eacute;xitosamente.";
			}
		}

		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listMember'));
	}
}
