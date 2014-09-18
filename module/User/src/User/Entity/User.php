<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 12:14 AM
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $fullName;

    /**
     * Get id
     *
     * @return interger
     */
    public function getId(){
        return $this->id;
    }

    /**
     *
     * Set full name
     * @param string $fullName
     * @return interger
     */
    public function setFullname($fullName){
        $this->fullName = $fullName;

        return $this;
    }
}