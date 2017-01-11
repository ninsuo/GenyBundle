<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataText
 *
 * @ORM\Table("geny_data")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\DataRepository")
 */
class Data {

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
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="datas")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $field_id;

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
     * Get field_id
     *
     * @return integer
     */
    public function getFieldID() {
        return $this->field_id;
    }

    /**
     * Set field_id
     *
     * @param integer $field_id
     *
     * @return Data
     */
    public function setFieldID($field_id) {
        $this->field_id = $field_id;

        return $this;
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
