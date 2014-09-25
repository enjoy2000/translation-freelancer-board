<?php
/**
 * Created by PhpStorm.
 * User: eastagile
 * Date: 9/24/14
 * Time: 7:02 PM
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;

use User\Entity\User;

class AbstractActionController extends ZendAbstractActionController{

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
