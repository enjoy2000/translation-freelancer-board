<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 7:23 AM
 */
namespace Api\Controller\Common;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;
use Common\Entity\Unit;

class UnitController extends AbstractRestfulController
{
    public function getList()
    {
        $units = $this->getAllData('\Common\Entity\Unit');

        return new JsonModel($units);
    }
}