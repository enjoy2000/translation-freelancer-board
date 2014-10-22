<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Papertask;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;
use Admin\Entity\ProfileServiceTranslationTM;

class TranslationtmController extends AbstractRestfulController{
    public function getList(){
        $data = [
            'translationTM' => $this->getAllData('\Admin\Entity\ProfileServiceTranslationTM')
        ];

        return new JsonModel($data);
    }

    public function update($id, $data){

    }
} 