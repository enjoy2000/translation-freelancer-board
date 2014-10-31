<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 7:23 AM
 */
namespace Api\Controller\Data;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;
use User\Entity\Staff;

class ProjectController extends AbstractRestfulController
{
    public function getList()
    {
        $config = $this->getServiceLocator()->get('Config');
        $projectTypes = $config['project_create'];

        $data = [];
        $data['languages'] = $this->getAllData('\User\Entity\Language');
        $data['interpretings'] = $this->getAllDataBy('\User\Entity\Resource', [
            'group' => $this->getEntityManager()->getReference('\User\Entity\Resource', 3)
        ]);
        $data['clients'] = $this->getAllData('\User\Entity\Employer');
        $data['fields'] = $this->getAllData('\User\Entity\Field');
        $data['pms'] = $this->getAllDataBy('\User\Entity\Staff', ['type' => Staff::STAFF_TYPE_PM]);
        $data['sales'] = $this->getAllDataBy('\User\Entity\Staff', ['type' => Staff::STAFF_TYPE_SALE]);
        $data = array_merge($data, $projectTypes);

        return new JsonModel($data);
    }
}