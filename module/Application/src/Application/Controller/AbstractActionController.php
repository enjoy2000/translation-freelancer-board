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

    public function getEntityManager(){
        return $entityManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
    }
}
