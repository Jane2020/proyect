<?php

namespace Payment\SecurityBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Payment\SecurityBundle\Form\Type\UserSearchType;
use Payment\SecurityBundle\Entity\UserSearch;
use Payment\ApplicationBundle\Libraries\Paginator\Paginator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Payment\SecurityBundle\Form\Type\UserEditType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Payment\SecurityBundle\Form\Type\UserProfileType;

/**
 * Controlador para administración de usuarios
 * @author Infoquality S.A.
 *
 */
class AdministrationController extends Controller {

    const LIMIT_PAGINATOR = 10;

    /**
     * @Template()	
     * @Secure(roles="ROLE_ADMIN")  
     */
    public function listUsersAction(Request $request) {
        $userEntity = new UserSearch();
        $limit = self::LIMIT_PAGINATOR;
        $offset = 0;
        $userText = null;
        $user = $this->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        $userForm = $this->createForm(new UserSearchType(), $userEntity);
        if ($request->getMethod() == 'POST') {
            $userForm->bind($request);
            $datas = $userForm->getData();
            if ($userForm->isValid()) {
                $userText = $datas->getName();
                $offset = $datas->getOffset();
                $limit = $datas->getLimit();
            }
        }

        $offsetItem = $offset;
        if ($offsetItem > 0) {
            $offsetItem = $offsetItem - 1;
        }
        $offsetItem = $offsetItem * $limit;
        $total = $this->findUserByUsernameToListUsers($userId, $userText, $offsetItem, $limit);
        $total = $total[0][1];
        $users = $this->findUserByUsernameToListUsers($userId, $userText, $offsetItem, $limit, false);
        $paginator = new Paginator($userForm->getName(), $total, $offset, $limit);

        return array('form' => $userForm->createView(), 'limit' => $limit, 'total' => $total, 'users' => $users, 'paginator' => $paginator, 'roles' => $this->getRoles());
    }

    /**
     * Secure(roles="ROLE_ADMIN")  
     */
    public function activeUserAction(Request $request) {
        $userId = $this->getUserIdToAction($request);
        $publish = $request->request->get('publish');
        if ($this->actionToUserById($userId, true, $publish)) {
            if ($publish == 1) {
                $message = "El usuario ha sido Activado &eacute;xitosamente.";
            } else {
                $message = "El usuario ha sido Desactivado &eacute;xitosamente.";
            }
        } else {
            $message = "No se ha podido realizar la tarea por favor int&eacute;ntelo m&aacute;s tarde.";
        }
        $this->get('session')->getFlashBag()->add('message', $message);
        return $this->redirect($this->generateUrl('_listUser'));
    }

    /**
     * Secure(roles="ROLE_ADMIN")
     */
    public function deleteUserAction(Request $request) {
        $userId = $this->getUserIdToAction($request);

        if ($this->actionToUserById($userId)) {
            $message = "El usuario ha sido Eliminado &eacute;xitosamente.";
        } else {
            $message = "No se ha podido realizar la tarea por favor int&eacute;ntelo m&aacute;s tarde.";
        }
        $this->get('session')->getFlashBag()->add('message', $message);
        return $this->redirect($this->generateUrl('_listUser'));
    }

    /**
     * @Template()
     * Secure(roles="ROLE_ADMIN")
     */
    public function editUserAction(Request $request) {
        $title = "Crear";
        $userId = $this->getUserIdToAction($request);
        $userEditId = $request->request->get('userEdit');
        if ($userEditId['id'] > 0) {
            $userId = $userEditId['id'];
            $userAdmin = $this->get('security.context')->getToken()->getUser();
            $adminId = $userAdmin->getId();
            if ($userId == $adminId) {
                throw new AccessDeniedException();
            }
        }

        $user = $this->getUserByEdit($userId);
        $user->setCanonical($user->getUsernameCanonical());
        $roles = $this->getRoles();
  
        $userForm = $this->createForm(new UserEditType($roles), $user);
        if ($request->getMethod() == 'POST') {
            $band = $request->request->get('band', 0);
            if ($band != 0) {

                $userForm->bind($request);                
                $datas = $userForm->getData();

                if ($userForm->isValid()) {
                	$user->setUsernameCanonical($user->getCanonical());
                    if ($this->isUniqueUser($user, $message)) {
                    	
                    	$user->setUsername($user->getUsernameCanonical());                    	
                        if ($this->saveUser($user)) {                           
                            $this->get('session')->getFlashBag()->add('message', 'El Usuario ha sido almacenado &eacute;xitosamente.');
                        } else {
                            $this->get('session')->getFlashBag()->add('message', 'No se ha podido realizar la tarea por favor int&eacute;ntelo m&aacute;s tarde.');
                        }
                        return $this->redirect($this->generateUrl('_listUser'));
                    }
                    $this->get('session')->getFlashBag()->add('message', $message);
                }
            }
        }
        if ($userId > 0) {
            $title = "Editar";
        }
        return array('form' => $userForm->createView(), 'title' => $title);
    }

    /**
     * @Template()
     */
    public function editProfileAction(Request $request) {
        $userAdmin = $this->get('security.context')->getToken()->getUser();
        $userId = $userAdmin->getId();        
        $user = $this->getUserByField('id', $userId);
		$user->setCanonical($user->getUsernameCanonical());
        $userForm = $this->createForm(new UserProfileType(), $user);
        if ($request->getMethod() == 'POST') {
            $userForm->bind($request);
            $datas = $userForm->getData();
          
            if ($userForm->isValid()) {
            	$user->setUsernameCanonical($user->getCanonical());
                if ($this->isUniqueUser($user, $message)) {                	
                    $user->setUsername($user->getUsernameCanonical());
                    if ($this->saveUser($datas)) {
                        return $this->redirect($this->generateUrl('home'));
                    }
                    $message = 'La informaci&oacute;n no puedo ser almacenada por favor vuelva a ingresar';
                }
                $this->get('session')->getFlashBag()->add('message', $message);
            }
        }
        return array('form' => $userForm->createView(), 'username' => $userAdmin->getName());
    }

    /**
     * Función que busca a un usuario por un filtro dado para mostrarlo en un listado
     * @param string $userText Texto referente del usuario a buscar
     * @param integer $offset Numero de inicio para obtener los datos
     * @param integer $limit Numero de tope para obtener los datos
     * @param boolean $count Indica si la funcion devolvera el total de registros encontrados
     */
    private function findUserByUsernameToListUsers($userId, $userText, $offset, $limit, $count = true) {

        $queryBuilder = $this->getDoctrine()->getManager()->createQueryBuilder('u');
        if ($count) {
            $queryBuilder->add('select', $queryBuilder->expr()->count('u.id'));
        } else {
            $queryBuilder->add('select', 'u');
            $queryBuilder->orderBy('u.name');
            $queryBuilder->setFirstResult($offset);
            $queryBuilder->setMaxResults($limit);
        }
        $queryBuilder->add('from', 'PaymentSecurityBundle:User u');
        $queryBuilder->where($queryBuilder->expr()->neq('u.id', '?3'));
        if ($userText != null) {
            $userText = str_replace(' ', '%', $userText);
            $userText = '%' . strtolower($userText) . '%';
            $queryBuilder->andWhere(
                    $queryBuilder->expr()->orx(
                            $queryBuilder->expr()->like($queryBuilder->expr()->lower('u.username'), '?1'), $queryBuilder->expr()->like($queryBuilder->expr()->lower('u.name'), '?1'), $queryBuilder->expr()->like($queryBuilder->expr()->lower('u.lastname'), '?1'), $queryBuilder->expr()->like($queryBuilder->expr()->lower($queryBuilder->expr()->concat('u.name', $queryBuilder->expr()->concat('?2', 'u.lastname'))), '?1')
                    )
            );

            $space = ' ';
            $queryBuilder->setParameter(1, $userText);
            $queryBuilder->setParameter(2, $space);
        }
        $queryBuilder->setParameter(3, $userId);
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
        return $result;
    }

    /**
     * Función que obtiene un array de Roles para listado y edición de usuarios
     * @return array de roles
     */
    private function getRoles() {
        return array('ROLE_ADMIN' => 'Administrador', 'ROLE_SECRETARY' => 'Secretario', 'ROLE_TREASURER' => 'Tesorero', 'ROLE_OPERATOR' => 'Operador');
    }

    /**
     * Función que obtiene el id de usuario para ejecutar una accion sobre este
     * @param Request $request
     * @throws AccessDeniedException Se presetna si se intenta modificar los datos de usuario que sta en sesión
     */
    private function getUserIdToAction(Request $request) {
        $userId = $request->request->get('cid', 0);
        if (is_array($userId)) {
            $userId = $userId[0];
        }
        $user = $this->get('security.context')->getToken()->getUser();
        $adminId = $user->getId();
        if ($userId == $adminId) {
            throw new AccessDeniedException();
        }
        return $userId;
    }

    /**
     * Funcion que elimina, activa o desactiva un usuario dado el Id
     * @param integer $userId Id de usuario sobre el que se ejecutar la accion
     * @param boolean $active Bandera para indicar si es activación o eliminación la acción aejecutar
     * @param integer $publish Indica en caso que ea activación si es una activacion o desactivacion de usuario.
     */
    private function actionToUserById($userId, $active = false, $publish = 1) {
        $user = $this->getUserByField('id', $userId);
        if (!$user) {
            throw $this->createNotFoundException('No existe un usuario con el id: ' . $userId);
        }
        try {
            $userManager = $this->container->get('fos_user.user_manager');
            if ($active) {
                $user->setEnabled($publish);
                $userManager->updateUser($user);
            } else {
                $userManager->deleteUser($user);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Función que obtien un usuario para edición
     * @param integer $userId Id de Usuario a buscar
     */
    private function getUserByEdit($userId) {
        $userManager = $this->container->get('fos_user.user_manager');
        if ($userId == 0) {
            return $userManager->createUser();
        }
        $user = $this->getUserByField('id', $userId);
        if (!$user) {
            throw $this->createNotFoundException('No existe un usuario con el id: ' . $userId);
        }
        return $user;
    }

    /**
     * Función que almacena los datos de un usuario
     * @param User $user Objeto de tipo usuario ha almacenar
     */
    private function saveUser($user) {
        $userManager = $this->container->get('fos_user.user_manager');
        if (($user->getPlainPassword() == '******') && ($user->getPassword() != '')) {
            $user->setPlainPassword('');
        }
        try {
            
            $userManager->updateUser($user);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Función que obtien un usuario dado el campo
     * @param string $field Campo por el cual buscar
     * @param string $value Valos a buscar
     */
    private function getUserByField($field, $value) {
        $userManager = $this->container->get('fos_user.user_manager');
        $criteria = array($field => $value);
        return $userManager->findUserBy($criteria);
    }

    /**
     * Función que verifica si es un usuario unico 
     * @param User $user Objeto tipo usuario ha buscar si existe en la base
     * @param string $message Mensaje a mostar si exite alun campo repetido
     */
    private function isUniqueUser($user, &$message) {

        $userBase = $this->getUserByField('username', $user->getUsernameCanonical());

        if (($userBase) && ($userBase->getId() != $user->getId())) {
            $message = 'El Nombre de Usuario ya se encuetra registrado. Por favor ingrese otro Nombre de Usuario';
            return false;
        }

        $userBase = $this->getUserByField('email', $user->getEmail());
        if (($userBase) && ($userBase->getId() != $user->getId())) {
            $message = 'El E-mail ya se encuentra registrado. Por favor ingrese otro E-mail.';
            return false;
        }
        return true;
    }

}