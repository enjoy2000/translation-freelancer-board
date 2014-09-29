<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/27/14
 * Time: 8:30 PM
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController as ZendAbstractRestfulController;

class AbstractRestfulController extends ZendAbstractRestfulController{

    use ControllerMethods;

    public function getDataList($array){
        $data = [];
        foreach($array as $member){
            $data[] = $member->getData();
        }
        return $data;
    }

    function getAllData($entityPath){
        $rows = $this->getEntityManager()->getRepository($entityPath)->findAll();
        return $this->getDataList($rows);
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }

    # Override default actions as they do not return valid JsonModels
    public function create($data)
    {
        return $this->methodNotAllowed();
    }

    public function delete($id)
    {
        return $this->methodNotAllowed();
    }

    public function deleteList()
    {
        return $this->methodNotAllowed();
    }

    public function get($id)
    {
        return $this->methodNotAllowed();
    }

    public function getList()
    {
        return $this->methodNotAllowed();
    }

    public function head($id = null)
    {
        return $this->methodNotAllowed();
    }

    public function options()
    {
        return $this->methodNotAllowed();
    }

    public function patch($id, $data)
    {
        return $this->methodNotAllowed();
    }

    public function replaceList($data)
    {
        return $this->methodNotAllowed();
    }

    public function patchList($data)
    {
        return $this->methodNotAllowed();
    }

    public function update($id, $data)
    {
        return $this->methodNotAllowed();
    }
}