<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataText
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\DataTextRepository")
 */
class DataText
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="geny_data_text", type="string", length=255)
     */
    private $genyDataText;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set genyDataText
     *
     * @param string $genyDataText
     *
     * @return DataText
     */
    public function setGenyDataText($genyDataText)
    {
        $this->genyDataText = $genyDataText;

        return $this;
    }

    /**
     * Get genyDataText
     *
     * @return string
     */
    public function getGenyDataText()
    {
        return $this->genyDataText;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return DataText
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return DataText
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

