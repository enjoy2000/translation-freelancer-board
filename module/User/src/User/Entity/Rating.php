<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 11/6/2014
 * Time: 10:06 AM
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Entity;

/** @ORM\Entity */
class Rating extends Entity {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /** @ORM\Column(type="integer") */
    protected $value;

    /** @ORM\Column(type="string") */
    protected $name;

    public function getData(){
        return array(
            'id' => $this->id,
            'value' => $this->value,
            'name' => $this->name,
        );
    }

    public function getValue(){
        return $this->value;
    }

    public function getId(){
        return $this->id;
    }
} 