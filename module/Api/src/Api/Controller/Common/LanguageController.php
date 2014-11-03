<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 7:23 AM
 */
namespace Api\Controller\Common;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;
use User\Entity\Language;

class LanguageController extends AbstractRestfulController
{
    public function getList()
    {
        $languages = $this->getAllData('\User\Entity\Language');
        //var_dump($languages);die;
        $json = [];
        foreach($languages as $lang){
            $json[$lang['id']] = $lang['name'];
        }

        return new JsonModel($json);
    }
}