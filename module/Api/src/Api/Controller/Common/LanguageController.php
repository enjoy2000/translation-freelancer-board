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
use User\Entity\Language;

class CompanyController extends AbstractRestfulController
{
    public function getList()
    {
        $data = [
            'languages' => $this->getAllData('\User\Entity\Language')
        ];

        return new JsonModel($data);
    }
}