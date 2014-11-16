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
use User\Entity\Resume;

class ResumeController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $resume = $this->getEntityManager()->getRepository('\User\Entity\Resume')->findOneBy(['user' => $user]);

        return new JsonModel([
            'resume' => $resume->getData(),
        ]);
    }

    public function update($id, $data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($id);
        $resume = $entityManager->getRepository('\User\Entity\Resume')
            ->findOneBy(['user' => $user]);
        $data['user'] = $user;
        $resume->setData($data);
        $resume->save($entityManager);

        return new JsonModel([]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($data['user_id']);
        $data['user'] = $user;
        $resume = new Resume();

        $resume->setData($data);
        $resume->save($entityManager);

        return new JsonModel([]);
    }
}