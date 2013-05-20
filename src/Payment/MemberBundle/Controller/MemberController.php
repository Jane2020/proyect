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
	 * @Secure(roles="ROLE_SECRETARY")
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
						$memberDocumentNumber, true, $offsetItem, $limit);
		$total = $total[0][1];
		$member = $this->getDoctrine()->getManager()
				->getRepository('PaymentDataAccessBundle:Member')
				->findMemberByParametersToList($memberName, $memberLastName,
						$memberDocumentNumber, true, $offsetItem, $limit, false);
		$paginator = new Paginator($memberTypeForm->getName(), $total, $offset,
				$limit);
		return array('form' => $memberTypeForm->createView(),
				'limit' => $limit, 'total' => $total, 'member' => $member,
				'paginator' => $paginator);
	}

	/**
	 * Secure(roles="ROLE_SECRETARY")
	 */
	public function deleteMemberAction(Request $request) {
		return $this->actionToMember($request, false);
	}

	/**
	 * Secure(roles="ROLE_SECRETARY")
	 */
	public function activeMemberAction(Request $request) 
	{
		return $this->actionToMember($request);
	}

	/**
	 * @Template()
	 * Secure(roles="ROLE_SECRETARY")
	 */
	public function editMemberAction(Request $request) 
	{
		$title = "Edición";
		$memberId = $request->request->get('cid', 0);
		if (is_array($memberId)) 
		{
			$memberId = $memberId[0];
		}
		$em = $this->getDoctrine()->getManager();
		if ($memberId > 0) 
		{
			$member = $em->getRepository('PaymentDataAccessBundle:Member')->find($memberId);
			$member->setBirthDate($member->getBirthDate()->format('Y-m-d'));
		}
		else 
		{
			$member = new Member();
			$title = "Creación";
		}
		
		$memberForm = $this->createForm(new MemberEditType(), $member);

		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0) 
			{
				$memberForm->bind($request);
				if ($memberForm->isValid()) 
				{
					if ($this->validationDocumentNumber($member->getDocumentNumber()))
					{	
						$member->setBirthDate(new \DateTime($member->getBirthDate()));
						$em->persist($member);
						$em->flush();
						$this->get('session')->getFlashBag()->add('message','El Item ha sido almacenado &eacute;xitosamente.');
						return $this->redirect($this->generateUrl('_listMember'));
					}
					else
					{
						$this->get('session')->getFlashBag()->add('message','Número de Cédula Incorrecto.');
					}
				}				
			}
		}
		return array('form' => $memberForm->createView(), 'title' => $title,'cid' => $memberId);
	}

	/**
	 * Obtiene la validación de la cédula de identidad
	 * 
	 * @param string $documentNumber
	 */
	private function validationDocumentNumber($documentNumber)
	{
		$provinceNumber = 24;
		if ((strlen($documentNumber) != 10) && (preg_match("/^[0-9]{10}$", $document_number)))
		{
			return false;
		}
		$province = substr($documentNumber, 0, 2);
		if (!(($province > 0) && ($province <= $provinceNumber)))
		{
			return false;
		}
		$d = str_split($documentNumber);
		$imp = 0;
		$par = 0;
		$len = count($d);
		for ($i = 0; $i < $len; $i += 2)
		{
			$d[$i] = (($d[$i] * 2) > 9) ? (($d[$i] * 2) - 9) : ($d[$i] * 2);
			$imp = $imp + $d[$i];
		}
		
		//sumamos los digitos de posición par
		for ($i = 1; $i < ($len - 1); $i += 2)
		{
			$d[$i] = $d[$i] * 1;
			$par = $par + $d[$i];
		}
		//Sumamos los dos resultados
		$suma = $imp + $par;
		 
		//Restamos de la decena superior
		$d10=$suma/10;
		$d10=floor($d10);
		$d10=($d10+1)*10;
		$d10=($d10-$suma);
		 
		//Si es diez el décimo dígito es cero
		$d10 = ($d10 == 10) ? 0 : $d10;
		
		if ($d10 == $d[9])
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	private function actionToMember(Request $request, $active = true) 
	{
		$memberId = $request->request->get('cid', 0);
		if (is_array($memberId)) 
		{
			$memberId = $memberId[0];
		}

		$em = $this->getDoctrine()->getManager();
		$member = $em->getRepository('PaymentDataAccessBundle:Member')
				->find($memberId);

		if (!$member) 
		{
			$message = "El item seleccionado no ha podido ser encontrado.";
		} 
		else 
		{
			if ($active) 
			{
				$publish = $request->request->get('publish');
				$member->setIsActive($publish);
				$em->flush();
				if ($publish == 1) 
				{
					$message = "El item ha sido Activado &eacute;xitosamente.";
				}
				else 
				{
					$message = "El item ha sido Desactivado &eacute;xitosamente.";
				}
			} 
			else 
			{
				$memberAssoc = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findBy(array('member'=>$memberId));
				if($memberAssoc)
				{
					$message = "El item no pudo ser Eliminado, esta relacionado con un medidor.";
				}
				else
				{
					$em->remove($member);
					$em->flush();
					$message = "El item ha sido Eliminado &eacute;xitosamente.";
				}
			}
		}

		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listMember'));
	}
}
