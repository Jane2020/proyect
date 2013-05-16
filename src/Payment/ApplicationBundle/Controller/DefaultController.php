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
	
	/**
	 * @Template()
	 *
	 */
	public function generalMenuAction(Request $request)
	{
		$rol = $this->get('security.context')->getToken()->getUser()->getRoles();
		$rol = trim($rol[0]);
		$parentMenu = $this->getDoctrine()->getRepository('PaymentDataAccessBundle:NavigationItem')->getMenus(0, $rol);
		return array('parentMenu'=>$parentMenu);
	}
	
	/**
     * 
     * @Template
	 *
     */
    public function deleteItemAction()
    {
        $req = $this->getRequest();
        $cid = $req->get('cid', 1);
		$link = $req->get('link');
        return $this->render("PaymentApplicationBundle:Delete:delete.html.twig", array('cid' => $cid, 'link' => $link));
    }
    
    /**
     *
     * @Template
     *
     */
    public function configurationItemAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$validationArray = array();
    	$inputValue = null;
    	$rexValue = null;
    	$nameValue = null;
    	$parameters = $this->getDoctrine()->getRepository('PaymentDataAccessBundle:Parameter')->findBy(array(), array('order' => 'asc'));
    	$countParameter = count($parameters);
    	$i=1;
    	foreach ($parameters as $item)
    	{
    		$inputValue = $inputValue.$item->getKey();
    		$rexValue = $rexValue."".$item->getRexType()."";
    		$nameValue = $nameValue.$item->getValue();
    		if ($i < $countParameter)
    		{
    			$inputValue = $inputValue.',';
    			$rexValue = $rexValue.';';
    			$nameValue = $nameValue.',';
    		}
    		$i++;
    	}
    	if ($request->getMethod() == 'POST')
    	{
    		foreach ($parameters as $item)
    		{
    			$parameter = $request->request->get($item->getKey());
    			$name= $item->getName();
    			$validation = $this->validationParameters($parameter, $item->getRexType());
    			$item->setValue(trim($parameter));
    			if ($validation == false)
    			{
    				$validationArray[] = 'Por favor ingrese correctamente el '.$name;
    			}
    		}    		 
    		if (!$validationArray)
    		{
    			foreach ($parameters as $item)
    			{
    				$em->persist($item);
    				$em->flush();
    			}
    			$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
    			return $this->render("PaymentApplicationBundle:Default:welcome.html.twig");
    		}
    	}  
    	return $this->render("PaymentApplicationBundle:Configuration:configurationItem.html.twig", array('parameters' => $parameters, 'validationArray' => $validationArray, 'inputValue'=>$inputValue, 'rexValue' => $rexValue, 'nameValue' => $nameValue));
    }
    
    /**
     * Función que realiza la validación de los parametros ingresados. 
     * 
     * @param string $parameter
     * @param string $rexType
     */
    private function validationParameters($parameter, $rexType)
    {
    	$rexType = "'".$rexType."'";
    	if (!$parameter or (!preg_match($rexType, $parameter)))
    	{
    		return false;
    	}	
    	return true; 
    }
}