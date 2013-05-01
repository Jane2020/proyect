<?php

namespace Payment\MeterBundle\Controller;

use Payment\MeterBundle\Form\Type\MeterSearchType;
use Payment\MeterBundle\Entity\MeterSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\DataAccessBundle\Entity\Member;


class MeterController extends Controller
{
	/**
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
    public function listMeterAction(Request $request)
    {
    	$meterEntity = new MeterSearch();
    	$limit = self::LIMIT_PAGINATOR;
        $offset = 1;
        $meterNumber = null;
        
        $meterForm = $this->createForm(new MeterSearchType(), $meterEntity);
        if ($request->getMethod() == 'POST') 
        {
            $meterForm->bind($request);
            $datas = $meterForm->getData();
            if ($meterForm->isValid())
            {
                $meterNumber = $datas->getNumber();
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
        $total = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findMeterByParametersToList($meterNumber, $offsetItem, $limit);
        $total = $total[0][1];
        $meter = $this->getDoctrine()->getManager()->getRepository('PaymentDataAccessBundle:Account')->findMeterByParametersToList($meterNumber, $offsetItem, $limit, false);
        $paginator = new Paginator($meterForm->getName(), $total, $offset, $limit);
        return array('form' => $meterForm->createView(), 'limit' => $limit, 'total' => $total, 'meter' => $meter, 'paginator' => $paginator);
    }
}