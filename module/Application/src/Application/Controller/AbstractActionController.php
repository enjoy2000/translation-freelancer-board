<?php
/**
 * Created by PhpStorm.
 * User: eastagile
 * Date: 9/24/14
 * Time: 7:02 PM
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;

class AbstractActionController extends ZendAbstractActionController{

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
}
