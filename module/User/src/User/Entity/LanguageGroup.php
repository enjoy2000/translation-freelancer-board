<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 11:51 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class LanguageGroup{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    /**
     * @return array
     */
    public function getData(){
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
}