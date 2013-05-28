<?php
namespace Payment\ManagerialBundle\Controller;

use Payment\ManagerialBundle\Form\Type\ManagerialMemberEditType;
use Payment\ManagerialBundle\Form\Type\ManagerialEditType;
use Payment\DataAccessBundle\Entity\ManagerialMember;
use Payment\ManagerialBundle\Form\Type\ManagerialMemberSearchType;
use Payment\ManagerialBundle\Entity\ManagerialMemberSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;


class ManagerialMemberController  extends Controller
{
	
	const LIMIT_PAGINATOR = 10;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function listManagerialMemberAction(Request $request)
	{
		$managerialMemberEntity = new ManagerialMemberSearch();
		$limit = self::LIMIT_PAGINATOR;
		$offset = 0;
		$managerialMemberText = null;
		$managerialMemberForm = $this->createForm(new ManagerialMemberSearchType(), $managerialMemberEntity);
		if ($request->getMethod() == 'POST')
		 {
			$managerialMemberForm->bind($request);
			$datas = $managerialMemberForm->getData();
			if ($managerialMemberForm->isValid()) 
			{
				$managerialMemberText = $datas->getName();
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
		$total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:ManagerialMember')->findManagerialMemberByNameToList($managerialMemberText, $offsetItem, $limit);
		$total = $total[0][1];
		$managerialMember = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:ManagerialMember')->findManagerialMemberByNameToList($managerialMemberText, $offsetItem, $limit, false);
		$paginator = new Paginator($managerialMemberForm->getName(), $total, $offset, $limit);
		return array('form' => $managerialMemberForm->createView(), 'limit' => $limit, 'total' => $total, 'managerialMember' => $managerialMember, 'paginator' => $paginator);
	}
	
	/**
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function activeManagerialMemberAction(Request $request)
	{
		return $this->actionToManagerialMember($request);
	}
	
	private function actionToManagerialMember(Request $request, $active = true)
	{
		$managerialmemberId = $request->request->get('cid', 0);
		if (is_array($managerialmemberId)) 
		{
			$managerialmemberId = $managerialmemberId[0];
		}
		$em = $this->getDoctrine()->getManager();
		$managerialMember = $em->getRepository('PaymentDataAccessBundle:ManagerialMember')->find($managerialmemberId);
	
		if (!$managerialMember) 
		{
			$message = "El item seleccionado no ha podido ser encontrado.";
		} 
		else 
		{
			if ($active)
			{
				$publish = $request->request->get('publish');
				if ($publish == 1)
				{
					$managerialMember->setActivationDate(new \DateTime());
					$managerialMember->setDesactivationDate(null);
				}
				else
				{
					$managerialMember->setDesactivationDate(new \DateTime());
				}
				$managerialMember->setIsActive($publish);
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
		}	
		$this->get('session')->getFlashBag()->add('message', $message);
		return $this->redirect($this->generateUrl('_listManagerialMember'));
	}
	
	/**
	 * @Template()
	 * Secure(roles="ROLE_ADMIN")
	 */
	public function editManagerialMemberAction(Request $request)
	{
		$title = "Editar";
		$managerialMemberId = $request->request->get('cid', 0);
		if (is_array($managerialMemberId)) 
		{
			$managerialMemberId = $managerialMemberId[0];
		}
	
		$em = $this->getDoctrine()->getManager();
		if ($managerialMemberId > 0)
		{
			$managerialMember = $em->getRepository('PaymentDataAccessBundle:ManagerialMember')->find($managerialMemberId);
			$managerialMember->setActivationDate($managerialMember->getManagerial()->getStartDate()->format('Y-m-d'));
			if ($managerialMember->getManagerial()->getEndDate())
			{
				$managerialMember->setDesactivationDate($managerialMember->getManagerial()->getEndDate()->format('Y-m-d'));
			}
			
			$managerialMember->setMemberId($managerialMember->getMember()->getId());
			$managerialMember->setMemberName($managerialMember->getMember()->getName().' '.$managerialMember->getMember()->getLastname());			
		} 
		else 
		{
			$managerialMember = new ManagerialMember();
			$title = "Crear";
		}
		$managerialMemberForm = $this->createForm(new ManagerialMemberEditType($em), $managerialMember);
		if ($request->getMethod() == 'POST') 
		{
			$band = $request->request->get('band', 0);
			if ($band != 0)
			{
				$managerialMemberForm->bind($request);
				if ($managerialMemberForm->isValid())
				{
					$member = $em->getRepository('PaymentDataAccessBundle:Member')->find($managerialMember->getMemberId());
					$user = $this->get('security.context')->getToken()->getUser();
					$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
					if ($managerialMemberId > 0)
					{
						if ($managerialMember->getIsActive())
						{
							$managerialMember->setActivationDate(new \DateTime());
							$managerialMember->setDesactivationDate(null);
						}		
						else
						{
							$managerialMember->setDesactivationDate(new \DateTime());
						}					
					}
					else 
					{
						$managerialMember->setActivationDate($managerialMember->getManagerial()->getStartDate());
						$managerialMember->setDesactivationDate($managerialMember->getManagerial()->getEndDate());
					}
					$managerialMember->setMember($member);
					$managerialMember->setSystemUser($userData);
					$validationCharge = $em->getRepository('PaymentDataAccessBundle:ManagerialMember')->assignedChargeExist($managerialMember->getMemberId(), $managerialMember->getManagerial()->getId(),$managerialMember->getCharge()->getId(), $managerialMember->getId());
					if ($validationCharge == false)
					{
						$em->persist($managerialMember);
						$em->flush();
						$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
						return $this->redirect($this->generateUrl('_listManagerialMember'));
					}
					else
					{
						$this->get('session')->getFlashBag()->add('message', 'No puede ser almacenado, el cargo o el miembro ya estan asignados para esa directiva.');
					}
				}
			}
		}
		return array('form' => $managerialMemberForm->createView(), 'title' => $title, 'cid'=>$managerialMemberId);
	}	
}