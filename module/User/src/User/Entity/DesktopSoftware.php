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
class DesktopSoftware{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", length=50) */
    protected $code;

    /** @ORM\Column(type="string", length=50) */
    protected $name;

    public function getData(){
        return array(
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
        );
    }

    public function getId(){
        return $this->id;
    }
}