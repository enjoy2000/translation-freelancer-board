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

class TranslationController extends AbstractRestfulController
{
    public function getList(){
        $data = array(
            'translationCatTools' => [],
            'translationSpecialisms' => [],
        );

        $entityManager = $this->getEntityManager();
        $catTools = $entityManager->getRepository('\User\Entity\CatTool')->findAll();
        $specialisms = $entityManager->getRepository('\User\Entity\Specialism')->findAll();

        foreach($catTools as $catTool){
            $data['translationCatTools'][] = $catTool->getData();
        }
        foreach($specialisms as $specialism){
            $data['translationSpecialisms'][] = $specialism->getData();
        }

        return new JsonModel($data);
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return void|JsonModel
     *
     * Data must contains
     * userTranslationCatTools - array of id
     * userTranslationSpecialisms - array of id
     */
    public function update($id, $data){
        $entityManager = $this->getEntityManager();

        $userTranslationCatTools = $data['userTranslationCatTools'];
        $userTranslationSpecialisms = $data['userTranslationSpecialisms'];

        $user = $this->getCurrentUser();
        $user->updateTranslationCatTools($entityManager, $userTranslationCatTools);
        $user->updateTranslationSpecialisms($entityManager, $userTranslationSpecialisms);
        $user->save($entityManager);

        return new JsonModel(array());
    }

}