<?php

namespace Payment\SecurityBundle\Controller;

use \Symfony\Component\Security\Core\SecurityContext;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{

    /**
     * Accion para inicio de sesion
     * @return Template()
     */
    public function loginAction()
    {
        $user = $this->get('security.context');
        if ($user->isGranted('ROLE_RECRUITER') || $user->isGranted('ROLE_ADMIN') || $user->isGranted('ROLE_STUDENT'))
        {
            return $this->redirect($this->generateUrl('home'));
        }
        
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('PaymentSecurityBundle:Security:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error));
    }

    /**
     * Para presentar el cierre de sesión
     * 
     * @return Template
     */
    public function logoutAction()
    {
        return $this->render('PaymentSecurityBundle:Security:logout.html.twig');
    }

}

?>
