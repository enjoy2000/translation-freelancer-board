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

class LanguageGroupController extends AbstractRestfulController
{
    public function getList()
    {
        $languageGroups = $this->getAllData('\User\Entity\LanguageGroup');
        //var_dump($languages);die;
        $json = [];
        foreach($languageGroups as $group){
            $json[$group['id']] = $group['name'];
        }

        return new JsonModel($json);
    }
}