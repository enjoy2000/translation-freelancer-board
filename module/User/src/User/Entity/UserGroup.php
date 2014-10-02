<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 9/21/2014
 * Time: 8:12 AM
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class UserGroup{

    const FREELANCER_GROUP_ID = 1;
    const EMPLOYER_GROUP_ID = 2;
    const ADMIN_GROUP_ID = 3;

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    /** @ORM\Column(type="string") */
    protected $firstLoginUrl = '';

    public function getData(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'isFreelancer' => $this->isFreelancer(),
            'isAdmin' => $this->isAdmin(),
            'isEmployer' => $this->isEmployer(),
        );
    }

    public function getId(){
        return $this->id;
    }

    public function getFirstLoginUrl(){
        return $this->firstLoginUrl;
    }

    /**
     * @return bool
     */
    public function isEmployer(){
        return $this->id == static::EMPLOYER_GROUP_ID;
    }

    /**
     * @return bool
     */
    public function isFreelancer(){
        return $this->id == static::FREELANCER_GROUP_ID;
    }

    /**
     * @return bool
     */
    public function isAdmin(){
        return $this->id == static::ADMIN_GROUP_ID;
    }
}