<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Papertask;

use Admin\Entity\ProfileServiceDesktopPublishing;
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class DesktopPublishingController extends AbstractRestfulController{

    public function getList(){
        $desktopPublishing = $this->getAllData('\Admin\Entity\ProfileServiceDesktopPublishing');
        $data = [
            'softwarePrices' => $desktopPublishing
        ];

        return new JsonModel($data);
    }

    public function update($id, $option){
        $entityManager = $this->getEntityManager();
        $desktopPublishing = $entityManager->find('\Admin\Entity\ProfileServiceDesktopPublishing', (int)$id);
        $desktopPublishing->setData($option);
        $entityManager->merge($desktopPublishing);
        $entityManager->flush();

        return new JsonModel([]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $desktopPublishing = new ProfileServiceDesktopPublishing();
        $desktopPublishing->setData($data);
        $desktopPublishing->save($entityManager);

        return new JsonModel([
            'softwarePrice' => $desktopPublishing->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $profileServiceDesktopPublishing = $entityManager->find('\Admin\Entity\ProfileServiceDesktopPublishing', $id);
        $entityManager->remove($profileServiceDesktopPublishing);
        $entityManager->flush();

        return new JsonModel([]);
    }
} 