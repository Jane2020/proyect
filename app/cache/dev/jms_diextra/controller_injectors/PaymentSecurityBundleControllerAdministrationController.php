<?php

namespace Payment\SecurityBundle\Controller;

/**
 * This code has been auto-generated by the JMSDiExtraBundle.
 *
 * Manual changes to it will be lost.
 */
class AdministrationController__JMSInjector
{
    public static function inject($container) {
        require_once '/home/fabian/localhost/payment/app/cache/dev/jms_diextra/proxies/Payment-SecurityBundle-Controller-AdministrationController.php';
        $a = new \JMS\AopBundle\Aop\InterceptorLoader($container, array('Payment\\SecurityBundle\\Controller\\AdministrationController' => array('listUsersAction' => array(0 => 'security.access.method_interceptor'))));
        $instance = new \EnhancedProxy_d9e7e701e8d845e4d484741ea7936890662c7a08\__CG__\Payment\SecurityBundle\Controller\AdministrationController();
        $instance->__CGInterception__setLoader($a);
        return $instance;
    }
}
