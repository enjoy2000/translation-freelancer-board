<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/27/14
 * Time: 10:28 PM
 */

namespace Application\Controller;

use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;

use User\Entity\User;


trait ControllerMethods{

    /**
     * @var bool
     */
    protected $requiredLogin = false;

    /**
     * @var null|\User\Entity\User
     */
    protected $currentUser = null;

    protected $_entityManager = null;

    /**
     * Dispatch a request
     *
     * @events dispatch.pre, dispatch.post
     * @param  Request $request
     * @param  null|Response $response
     * @return Response|mixed
     */
    public function dispatch(Request $request, Response $response = null){
        if($this->requiredLogin){
            $user = $this->getCurrentUser();
            if(!$user){
                $msg = $this->getTranslator()->translate("You must login in order to process this page.");
                $this->flashMessenger()->addErrorMessage($msg);
                /** @var \Zend\Uri\Http $url */
                $uri = $request->getUri();
                $requestUri = $uri->getPath() . ($uri->getQuery() ? "?" . $uri->getQuery() : "");
                return $this->redirect()->toUrl("/user/login?next=" . $requestUri);
            }
        }
        return parent::dispatch($request, $response);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager(){
        if($this->_entityManager === null){
            $this->_entityManager = $this->getServiceLocator()
                                         ->get('Doctrine\ORM\EntityManager');
        }
        return $this->_entityManager;
    }

    /**
     * @param $entityName
     * @param $criteria
     * @return object
     */
    public function findOneBy($entityName, $criteria){
        $this->getEntityManager()->getRepository($entityName)->findOneBy($criteria);
    }

    /**
     * @param $entityName
     * @param $id
     * @return object
     */
    public function getReference($entityName, $id){
        return $this->getEntityManager()->getReference($entityName, $id);
    }

    /**
     * @param $criteria
     * @return null|\User\Entity\User
     */
    public function getUser($criteria){
        return $this->getEntityManager()->getRepository('\User\Entity\User')->findOneBy($criteria);
    }

    /**
     * @param integer $id
     * @return null|\User\Entity\User
     */
    function getUserById($id){
        return $this->getEntityManager()->find('\User\Entity\User', $id);
    }

    /**
     * Get base url
     * @return string
     */
    public function getBaseUrl(){
        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        return $base;
    }

    public function getTranslator(){
        return $this->getServiceLocator()->get('translator');
    }

    /**
     * @return null|\User\Entity\User
     */
    public function getCurrentUser(){
        if($this->currentUser === null){
            $userId = User::currentLoginId();
            if($userId){
                $this->currentUser = $this->getUserById($userId);
            }
        }
        return $this->currentUser;
    }
}