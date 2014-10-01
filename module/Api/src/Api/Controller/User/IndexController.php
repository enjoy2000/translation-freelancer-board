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

class IndexController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $userData = $user->getData();
        $userData['country'] = array(
            'select' => $userData['country'],  # ng-option
        );

        return new JsonModel(
            array(
                'user' => $userData,
            )
        );
    }

    public function update($id, $data){
        $data['country'] = $data['country']['select'];

        $data['profileUpdated'] = true;
        $user = $this->getCurrentUser();
        $user->updateData($data);

        $entityManager = $this->getEntityManager();
        $user->save($entityManager);

        return new JsonModel(array());
    }
}