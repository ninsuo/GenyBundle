<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataText
 *
 * @ORM\Table("geny_data_text")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\DataTextRepository")
 */
class DataText {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var FieldID
     *
     * @ORM\ManyToOne(targetEntity="Data", inversedBy="datatexts")
     * @ORM\JoinColumn(name="data_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $data_id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    public function __construct() {
        $this->createdAt = new \Datetime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get data_id
     *
     * @return integer
     */
    public function getDataID() {
        return $this->data_id;
    }

    /**
     * Set data_id
     *
     * @param integer $data_id
     *
     * @return DataText
     */
    public function setDataID($data_id) {
        $this->data_id = $data_id;

        return $this;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return DataText
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return DataText
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return DataText
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

}
