<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/29/14
 * Time: 8:32 AM
 */

namespace Common;


class Func {
    /**
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @return array
     */
    static public function getReferenceIds($collection){
        return $collection->map(function($obj){
            /** @var \User\Entity\Resource $obj */
            return $obj->getId();
        })->toArray();
    }
} 