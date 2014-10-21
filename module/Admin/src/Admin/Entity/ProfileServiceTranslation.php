<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

class ProfileServiceTranslation {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $sourceLanguage;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $targetLanguage;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $professionalPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $businessPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $premiumPrice;
} 