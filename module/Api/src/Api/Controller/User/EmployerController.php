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

class EmployerController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $employerData = $user->getEmployer()->getData();

        return new JsonModel([
            'employer' => $employerData,
        ]);
    }

    public function update($id, $data){
        $userId = $this->getEvent()->getRouteMatch()->getParam('user_id');
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($userId);

        $employer = $user->getEmployer();
        $employer->updateData($data);
        $employer->save($entityManager);

        return new JsonModel([]);
    }
}