<?php

namespace Payment\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PaymentReportBundle:Default:index.html.twig', array('name' => $name));
    }
}
