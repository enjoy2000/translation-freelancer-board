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
                return $this->redirect()->toUrl("/user/login");
            }
        }
        return parent::dispatch($request, $response);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager(){
        return $entityManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
    }

    /**
     * @param $criteria
     * @return null|\User\Entity\User
     */
    public function getUser($criteria){
        return $this->getEntityManager()->getRepository('\User\Entity\User')->findOneBy($criteria);
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
        $userId = User::currentLoginId();
        if($this->currentUser === null){
            $this->currentUser = $this->getUser(array('id' => $userId));
        }
        return $this->currentUser;
    }
}