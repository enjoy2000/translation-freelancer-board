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
use User\Entity\Company;

class CompanyController extends AbstractRestfulController
{
    public function getList()
    {
        $data = [
            'companies' => $this->getAllData('\User\Entity\Company')
        ];

        return new JsonModel($data);
    }

    public function create($data){
        $company = new Company();
        $company->setData($data);
        $company->save($this->getEntityManager());

        return new JsonModel([
            'company' => $company->getData(),
        ]);
    }
}