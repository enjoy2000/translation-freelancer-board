<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 9/22/2014
 * Time: 2:22 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class TemplateType {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;
    /**
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * Get id
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get type name
     * @return string
     */
    public function getName(){
        return $this->name;
    }
} 