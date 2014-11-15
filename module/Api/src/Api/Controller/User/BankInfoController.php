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
use Admin\Model\Helper;
use User\Entity\BankInfo;

class BankInfoController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $freelancer = $user->getFreelancer();
        $bankInfo = $this->getEntityManager()->getRepository('\User\Entity\BankInfo')->findOneBy(['freelancer' => $freelancer]);

        return new JsonModel([
            'bankInfo' => $bankInfo->getData(),
        ]);
    }

    public function update($id, $data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($id);
        $freelancer = $user->getFreelancer();
        $bankInfo = $entityManager->find('\User\Entity\BankInfo', (int)$data['id']);
        $data['freelancer'] = $freelancer;
        $bankInfo->setData($data);
        $bankInfo->save($entityManager);

        return new JsonModel(['updated' => true]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $bankInfo = new BankInfo();
        $data['freelancer'] = $this->getUserById((int)$data['user_id'])->getFreelancer();
        $bankInfo->setData($data);
        $bankInfo->save($entityManager);

        return new JsonModel(['created' => true]);
    }
}