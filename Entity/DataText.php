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
     * @var Field
     *
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="datatexts")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $field;

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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getField() {
        return $this->field;
    }

    public function setField($field) {
        $this->field = $field;

        return $this;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return text
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
