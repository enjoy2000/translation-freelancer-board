<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 9:16 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Resource{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    /** @ORM\ManyToOne(targetEntity="ResourceGroup") */
    protected $group;

    public function getData(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
        );
    }

    public function getGroup(){
        return $this->group;
    }

    public function getId(){
        return $this->id;
    }
}