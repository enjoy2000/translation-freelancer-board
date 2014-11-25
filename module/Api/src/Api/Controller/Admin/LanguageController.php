<?php
namespace Api\Controller\Admin;

use Zend\View\Model\JsonModel;

use Api\Controller\AbstractRestfulJsonController;

class LanguageController extends AbstractRestfulJsonController
{
    public function getList(){
        $languages = $this->getAllData('\User\Entity\Language');

        return new JsonModel(array(
            'languages' => $languages
        ));
    }
}