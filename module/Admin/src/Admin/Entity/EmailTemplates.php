<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 9/22/2014
 * Time: 2:18 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

class EmailTemplates {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\OneToOne(targetEntity="TemplateType")
     */
    protected $type;

    /**
     * Set Template type
     * @param TemplateType $type
     */
    public function setType(TemplateType $type){
        $this->type_id = $type;
    }

} 