<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Data;

use Admin\Entity\ProfileServiceTranslation;
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class TranslationController extends AbstractRestfulController{
    public function getList(){
        $data = [
            'translationTM' => $this->getAllData('\Admin\Entity\ProfileServiceTranslation')
        ];

        return new JsonModel($data);
    }

    public function create($data){
        $translation = new ProfileServiceTranslation();
        $translation->setData($data);
        $translation->save($this->getEntityManager());

        return new JsonModel([
            'translation' => $translation->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $profileServiceTranslation = $entityManager->find('\User\Entity\ProfileServiceTranslation', $id);
        $entityManager->remove($profileServiceTranslation);
        $entityManager->flush();

        return new JsonModel([]);
    }
} 