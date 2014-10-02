<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/27/14
 * Time: 9:19 PM
 */
namespace Api\Controller\User;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class EmployerDataController extends AbstractRestfulController
{
    public function getList()
    {
        $data = [];

        return new JsonModel($data);
    }
}