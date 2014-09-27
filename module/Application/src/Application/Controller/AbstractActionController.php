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
    use ControllerMethods;
}
