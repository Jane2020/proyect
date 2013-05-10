<?php
namespace Payment\TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExpenseController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PaymentTransactionBundle:Default:index.html.twig', array('name' => $name));
    }
}
