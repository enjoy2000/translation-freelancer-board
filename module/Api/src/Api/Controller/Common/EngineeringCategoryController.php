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
use Common\Entity\EngineeringCategory;

class EngineeringCategoryController extends AbstractRestfulController
{
    public function getList()
    {
        $categories = $this->getAllData('\Common\Entity\EngineeringCategory');

        return new JsonModel($categories);
    }
}