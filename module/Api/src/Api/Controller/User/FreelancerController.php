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

        return new JsonModel(
            array(
                'freelancer' => $freelancerData,
            )
        );
    }

    public function update($id, $data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($id);
        $freelancer = $user->getFreelancer();

        $freelancer->updateData($data, $entityManager);
        $freelancer->save($entityManager);

        return new JsonModel(array());
    }
}