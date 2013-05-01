<?php
namespace Payment\FinesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Payment\FinesBundle\Form\Type\FinesTypeSearchType;
use Payment\FinesBundle\Entity\FinesTypeSearch;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\DataAccessBundle\Entity\FinesType;
use Payment\FinesBundle\Form\Type\FinesTypeEditType;

class FinesTypeController extends Controller
{
	const LIMIT_PAGINATOR = 20;
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
 	public function listFinesTypeAction(Request $request) 
 	{
        $finesTypeEntity = new FinesTypeSearch();
        $limit = self::LIMIT_PAGINATOR;
        $offset = 0;
        $finesTypeText = null;
        
        $finesTypeForm = $this->createForm(new FinesTypeSearchType(), $finesTypeEntity);
        if ($request->getMethod() == 'POST') {
            $finesTypeForm->bind($request);
            $datas = $finesTypeForm->getData();
            if ($finesTypeForm->isValid()) {
                $finesTypeText = $datas->getName();
                $offset = $datas->getOffset();
                $limit = $datas->getLimit();
            }
        }
        $offsetItem = $offset;
        if ($offsetItem > 0) {
            $offsetItem = $offsetItem - 1;
        }
        $offsetItem = $offsetItem * $limit;
        $total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:FinesType')->findFinesTypeByNameToList($finesTypeText, $offsetItem, $limit);
        $total = $total[0][1];
        $finesType = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:FinesType')->findFinesTypeByNameToList($finesTypeText, $offsetItem, $limit, false);
        $paginator = new Paginator($finesTypeForm->getName(), $total, $offset, $limit);

        return array('form' => $finesTypeForm->createView(), 'limit' => $limit, 'total' => $total, 'finesType' => $finesType, 'paginator' => $paginator);
    }
	
    /**
     * Secure(roles="ROLE_ADMIN")
     */
    public function deleteFinesTypeAction(Request $request) 
    {
    	return $this->actionToFinesType($request,false);
    }
    
    /**
     * Secure(roles="ROLE_ADMIN")
     */
    public function activeFinesTypeAction(Request $request) 
    {
    	return $this->actionToFinesType($request);
    }
    
    /**
     * @Template()
     * Secure(roles="ROLE_ADMIN")
     */
    public function editFinesTypeAction(Request $request) 
    {    	
    	$title = "Editar";
    	$finesTypeId = $request->request->get('cid', 0);
    	if (is_array($finesTypeId)) {
    		$finesTypeId = $finesTypeId[0];
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	if ($finesTypeId > 0)
    	{
    		$finesType = $em->getRepository('PaymentDataAccessBundle:FinesType')->find($finesTypeId);
    	} else {
    		$finesType = new FinesType();
    		$title = "Crear";
    	}   
    	
    	$finesTypeForm = $this->createForm(new FinesTypeEditType(), $finesType);
    	
    	if ($request->getMethod() == 'POST') {
    		$band = $request->request->get('band', 0);
    		if ($band != 0) 
    		{    
    			$finesTypeForm->bind($request);    
    			if ($finesTypeForm->isValid()) 
    			{
    				$em->persist($finesType);
    				$em->flush();
    				$this->get('session')->getFlashBag()->add('message', 'El Item ha sido almacenado &eacute;xitosamente.');
    				
    				return $this->redirect($this->generateUrl('_listFinesType'));	
    			}
    		}
    	}
    	return array('form' => $finesTypeForm->createView(), 'title' => $title, 'cid'=>$finesTypeId);
    }
    
    private function actionToFinesType(Request $request, $active = true)
    {
    	$finesTypeId = $request->request->get('cid', 0);
    	if (is_array($finesTypeId)) {
    		$finesTypeId = $finesTypeId[0];
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$finesType = $em->getRepository('PaymentDataAccessBundle:FinesType')->find($finesTypeId);
    	 
    	if (!$finesType) {
    		$message = "El item seleccionado no ha podido ser encontrado.";
    	} else {
    		if ($active)
    		{
    			$publish = $request->request->get('publish');
    			$finesType->setIsActive($publish);
    			$em->flush();
    			if ($publish == 1) {
    				$message = "El item ha sido Activado &eacute;xitosamente.";
    			} else {
    				$message = "El item ha sido Desactivado &eacute;xitosamente.";
    			}
    		} else {
	    		$em->remove($finesType);
	    		$em->flush();
	    		$message = "El item ha sido Eliminado &eacute;xitosamente.";
    		}
    	}
    	 
    	$this->get('session')->getFlashBag()->add('message', $message);
    	return $this->redirect($this->generateUrl('_listFinesType'));
    }
}