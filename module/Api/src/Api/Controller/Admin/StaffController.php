<?php
namespace Api\Controller\Admin;

use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Admin\Model\Helper;
use Api\Controller\AbstractRestfulJsonController;
use User\Entity\Iterm;
use User\Entity\Project;
use User\Entity\UserGroup;

class StaffController extends AbstractRestfulJsonController
{
    public function getList(){
        $params = [];
        if($type = $this->params()->fromQuery('type')){
            $params['type'] = (int) $type;
        }
        if(empty($params)){
            $staffs = $this->getAllData('\User\Entity\Staff');
        } else {
            $staffs = $this->getAllDataBy('\User\Entity\Staff', $params);
        }

        return new JsonModel(array(
            'staffs' => $staffs
        ));
    }
}