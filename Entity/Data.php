<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Data
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
     * @var integer
     *
     * @ORM\Column(name="set_id", type="integer", nullable=true)
     */
    private $setId;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array", nullable=true)
     * 
     * @Serializer\Type("array")
     */
    protected $data = [];

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
     * Get set_id
     *
     * @return integer
     */
    public function getSetID() {
        return $this->set_id;
    }

    /**
     * Set set_id
     *
     * @param integer $set_id
     *
     * @return Data
     */
    public function setSetID($set_id) {
        $this->setId = $set_id;

        return $this;
    }

    /**
     * Set data
     *
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set set_id
     *
     * @param array $data
     *
     * @return array
     */
    public function setData($data = null) {
        $this->data = $data;

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Data
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
