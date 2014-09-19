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
    protected $firstName;

    /** @ORM\Column(type="string") */
    protected $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="Group")
     */
    protected $group;

    /** @ORM\Column(type="string") */
    protected $email;

    /** @ORM\Column(type="string") */
    protected $password;

    /** @ORM\Column(type="datetime") */
    protected $lastLogin;

    /** @ORM\Column(type="datetime") */
    protected $createdTime;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     *
     * Set group Id
     * @param integer
     */
    public function setGroupId(\User\Entity\Group $id){
        $this->group = $id;
    }

    /**
     * Set data
     * @return object
     */
    public function setData($arr){
        $this->lastName = $arr['lastName'];
        $this->firstName = $arr['firstName'];
        $this->email = $arr['email'];
        $this->password = $arr['password'];
        $this->lastLogin = $arr['lastLogin'];
        $this->createdTime = $arr['createdTime'];

        return $this;
    }
}

/** @ORM\Entity */
class Group{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;
}