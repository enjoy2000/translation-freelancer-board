<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

class ProfileServiceDesktopPublishing {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="LanguageGroup")
     */
    protected $languageGroup;

    /**
     * @ORM\ManyToOne(targetEntity="DesktopSoftware")
     */
    protected $desktopSoftware;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $priceApplePerPage;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $priceWindowPerPage;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $priceApplePerHour;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $priceWindowPerHour;
} 