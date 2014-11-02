<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Papertask;

use Admin\Entity\ProfileServiceTranslation;
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class TranslationController extends AbstractRestfulController{

    public function getList(){
        $translation = $this->getAllData('\Admin\Entity\ProfileServiceTranslation');
        foreach($translation as &$trans){
            $trans['sourceLanguage'] = $trans['sourceLanguage']->getId();
            $trans['targetLanguage'] = $trans['targetLanguage']->getId();
        }
        $data = [
            'translation' => $translation
        ];

        return new JsonModel($data);
    }

    public function update($id, $option){
        $entityManager = $this->getEntityManager();
        $translation = $entityManager->find('\Admin\Entity\ProfileServiceTranslation', (int)$id);
        $sourceLanguage = $entityManager->find('\User\Entity\Language', (int)$option['sourceLanguage']);
        $targetLanguage = $entityManager->find('\User\Entity\Language', (int)$option['targetLanguage']);
        $option['sourceLanguage'] = $sourceLanguage;
        $option['targetLanguage'] = $targetLanguage;
        $translation->setData($option);
        $entityManager->merge($translation);
        $entityManager->flush();

        return new JsonModel([]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $translation = new ProfileServiceTranslation();
        $sourceLanguage = $entityManager->find('\User\Entity\Language', (int)$data['sourceLanguage']);
        $targetLanguage = $entityManager->find('\User\Entity\Language', (int)$data['targetLanguage']);
        $data['sourceLanguage'] = $sourceLanguage;
        $data['targetLanguage'] = $targetLanguage;
        $translation->setData($data);
        $translation->save($entityManager);

        return new JsonModel([
            'translation' => $translation->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $profileServiceTranslation = $entityManager->find('\Admin\Entity\ProfileServiceTranslation', $id);
        $entityManager->remove($profileServiceTranslation);
        $entityManager->flush();

        return new JsonModel([]);
    }
} 