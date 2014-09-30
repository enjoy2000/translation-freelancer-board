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
        );
    }

    public function getId(){
        return $this->id;
    }

    public function getFirstLoginUrl(){
        return $this->firstLoginUrl;
    }
}