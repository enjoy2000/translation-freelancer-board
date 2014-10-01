<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 10/1/14
 * Time: 6:21 AM
 */

namespace Common;


class Entity {

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function save($entityManager){
        $entityManager->persist($this);
        $entityManager->flush();
    }
} 