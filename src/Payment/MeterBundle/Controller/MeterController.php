<?php

namespace Payment\MeterBundle\Controller;

use Payment\MeterBundle\Form\Type\MeterEditType;

use Payment\DataAccessBundle\Entity\Account;
use Payment\MeterBundle\Form\Type\MeterSearchType;
use Payment\MeterBundle\Entity\MeterSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;


class MeterController extends Controller
{
	const LIMIT_PAGINATOR = 10;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_SECRETARY")
	 */
    public function listMeterAction(Request $request)
    {
    	$meterEntity = new MeterSearch();
    	$limit = self::LIMIT_PAGINATOR;
        $offset = 0;
        $accountNumber = null;
        $d = new MeterSearchType();
        $meterForm = $this->createForm(new MeterSearchType(), $meterEntity);
        if ($request->getMethod() == 'POST') 
        {
            $meterForm->bind($request);
            $datas = $meterForm->getData();
            if ($meterForm->isValid())
            {
                $accountNumber = $datas->getAccountNumber();
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
        $total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findMeterByParametersToList($accountNumber, $offsetItem, $limit);
        $total = $total[0][1];
        $meter = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findMeterByParametersToList($accountNumber, $offsetItem, $limit, false);
        $paginator = new Paginator($meterForm->getName(), $total, $offset, $limit);
        return array('form' => $meterForm->createView(), 'limit' => $limit, 'total' => $total, 'meter' => $meter, 'paginator' => $paginator);
    }

    /**
     * Secure(roles="ROLE_SECRETARY")
     */
    public function deleteMeterAction(Request $request)
    {
    	return $this->actionToMeter($request,false);
    }
    
    /**
     * Secure(roles="ROLE_SECRETARY")
     */
    public function activeMeterAction(Request $request)
    {
    	return $this->actionToMeter($request);
    }

    private function actionToMeter(Request $request, $active = true)
    {
    	$accountId = $request->request->get('cid', 0);
    	if (is_array($accountId))
    	{
    		$accountId = $accountId[0];
    	}
    
    	$em = $this->getDoctrine()->getManager();
    	$account = $em->getRepository('PaymentDataAccessBundle:Account')->find($accountId);
    
    	if (!$account)
    	{
    		$message = "El item seleccionado no ha podido ser encontrado.";
    	}
    	else
    	{
    		if ($active)
    		{
    			$publish = $request->request->get('publish');
    			$account->setIsActive($publish);
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
    			$memberAssoc = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findBy(array('member'=>$account->getMember()->getId()));
    			if($memberAssoc)
    			{
    				$message = "El item no pudo ser Eliminado, esta relacionado con un miembro.";
    			}
    			else
    			{
    				$em->remove($account);
    				$em->flush();
    				$message = "El item ha sido Eliminado &eacute;xitosamente.";    				
    			}
    		}
    	}
    
    	$this->get('session')->getFlashBag()->add('message', $message);
    	return $this->redirect($this->generateUrl('_listMeter'));
    }
    
    /**
     * @Template()
     * Secure(roles="ROLE_SECRETARY")
     */
    public function editMeterAction(Request $request)
    {
    	$title = "Editar";
    	$accountId = $request->request->get('cid', 0);
    	if (is_array($accountId))
    	{
    		$accountId = $accountId[0];
    	}
    	$em = $this->getDoctrine()->getManager();
    	if ($accountId > 0)
    	{
    		$account = $em->getRepository('PaymentDataAccessBundle:Account')->find($accountId);
    		$account->setMemberId($account->getMember()->getId());
    		$account->setMemberName($account->getMember()->getName().' '.$account->getMember()->getLastname());    		
    	}
    	else
    	{
    		$account = new Account();
    		$title = "Crear";
    	}
		$sewerageArray = $this->getSewerageAll();
    	$accountForm = $this->createForm(new MeterEditType($em, $sewerageArray), $account);
    	if ($request->getMethod() == 'POST')
    	{
    		$band = $request->request->get('band', 0);
    		if ($band != 0)
    		{
    			$accountForm->bind($request);
    			if ($accountForm->isValid())
    			{
    				if ($account->getMemberId())
    				{
	    				$user = $this->get('security.context')->getToken()->getUser();
	    				$userId = $user->getId();
	    				$user = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($userId);
	    				$member = $em->getRepository('PaymentDataAccessBundle:Member')->find($account->getMemberId());
	    				$account->setMember($member);
	    				$account->setSystemUser($user);
	    				$em->persist($account);
	    				$em->flush();
	    				$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
	    				return $this->redirect($this->generateUrl('_listMeter'));
    				}
    				else
    				{
    					$this->get('session')->getFlashBag()->add('message', 'Por favor ingrese el nombre del miembro.');
    				}
    			}
    		}
    	}
    	return array('form' => $accountForm->createView(), 'title' => $title, 'cid'=>$accountId);
    }    
    
    private function getSewerageAll()
    {
    	$em = $this->getDoctrine()->getManager();
    	$sewearge = $em->getRepository('PaymentDataAccessBundle:Parameter')->find(11);
    	$seweargeMaximum = $sewearge->getValue();
    	for( $i=1; $i<= $seweargeMaximum; $i++)
    	{
    		$sewerageArray[$i] = $i;
    	}
    	return $sewerageArray;
    }
}