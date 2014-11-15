<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 11/6/2014
 * Time: 10:06 AM
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Country{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    public function getData(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
        );
    }

    public function getId(){
        return $this->id;
    }
} 