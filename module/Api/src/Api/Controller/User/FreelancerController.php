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

class FreelancerController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $freelancerData = $user->getFreelancer()->getData();

        return new JsonModel([
            'freelancer' => $freelancerData,
        ]);
    }

    public function update($id, $data){
        $userId = $this->getEvent()->getRouteMatch()->getParam('user_id');
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($userId);
        $freelancer = $user->getFreelancer();

        $freelancer->updateData($data, $entityManager);
        $freelancer->save($entityManager);

        return new JsonModel([]);
    }
}