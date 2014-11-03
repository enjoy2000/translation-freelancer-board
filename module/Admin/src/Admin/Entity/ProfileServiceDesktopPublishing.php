<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Common\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class ProfileServiceDesktopPublishing extends Entity {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\LanguageGroup")
     */
    protected $languageGroup;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\DesktopSoftware")
     */
    protected $desktopSoftware;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $priceApplePerPage;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $priceWindowPerPage;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $priceApplePerHour;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $priceWindowPerHour;


    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'languageGroup',
            'desktopSoftware',
            'priceApplePerPage',
            'priceWindowPerPage',
            'priceApplePerHour',
            'priceWindowPerHour',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getData(){
        return array(
            'id' => $this->id,
            'languageGroup' => $this->languageGroup->getData(),
            'desktopSoftware' => $this->desktopSoftware->getData(),
            'priceApplePerPage' => $this->priceApplePerPage,
            'priceWindowPerPage' => $this->priceWindowPerPage,
            'priceApplePerHour' => $this->priceApplePerHour,
            'priceWindowPerHour' => $this->priceWindowPerHour,
        );
    }
} 