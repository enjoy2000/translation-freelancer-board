<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 10/6/14
 * Time: 8:42 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Entity;


/** @ORM\Entity */
class Project extends Entity{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @var \User\Entity\Language
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $sourceLanguage;

    /**
     * @var \User\Entity\Language
     * @ORM\ManyToMany(targetEntity="Language")
     */
    protected $targetLanguages;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $reference;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $priority;

    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    protected $dueDate;

    /**
     * @var \User\Entity\Field
     * @ORM\ManyToOne(targetEntity="Field")
     */
    protected $field;

    /**
     * @var \User\Entity\Employer
     * @ORM\ManyToOne(targetEntity="Employer")
     */
    protected $client;

    /**
     * @var \User\Entity\Staff
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinTable(name="ProjectSale")
     */
    protected $sale;

    /**
     * @var \User\Entity\Staff
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinTable(name="ProjectPm")
     */
    protected $pm;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=True)
     */
    protected $interpretingInfo;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $serviceLevel = 0;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $duration = 0;

    /**
     * @var \User\Entity\Iterm
     * @ORM\ManyToMany(targetEntity="Iterm")
     * @ORM\JoinTable(name="ProjectInterpretingIterm")
     */
    protected $interpretingIterms;

    /**
     * @var \User\Entity\Iterm
     * @ORM\ManyToMany(targetEntity="Iterm")
     * @ORM\JoinTable(name="ProjectDtpPcIterm")
     */
    protected $dtpPcIterms;

    /**
     * @var \User\Entity\Iterm
     * @ORM\ManyToMany(targetEntity="Iterm")
     * @ORM\JoinTable(name="ProjectDtpMacIterm")
     */
    protected $dtpMacIterms;

    /**
     * @var \User\Entity\Iterm
     * @ORM\ManyToMany(targetEntity="Iterm")
     * @ORM\JoinTable(name="ProjectEngineeringIterm")
     */
    protected $engineeringIterms;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $is_deleted = 0;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $payStatus = 1;  # unpaid

    public function getData(){
        return [
            'id' => $this->id,
            'status' => $this->status,
            'sourceLanguage' => $this->sourceLanguage->getData(),
            'targetLanguages' => $this->getArrayData($this->targetLanguages),
            'reference' => $this->reference,
            'priority' => $this->priority,
            'startDate' => $this->startDate,
            'dueDate' => $this->dueDate,
            'field' => $this->field->getData(),
            'client' => $this->client->getData(),
            'sale' => $this->sale->getData(),
            'pm' => $this->pm->getData(),
            'interpretingInfo' => $this->interpretingInfo,
            'serviceLevel' => $this->serviceLevel,
            'duration' => $this->duration,
            'interpretingIterms' => $this->interpretingIterms,
            'dtpPcIterms' => $this->dtpPcIterms,
            'dtpMacIterms' => $this->dtpMacIterms,
            'engineeringIterms' => $this->engineeringIterms,
        ];
    }
}