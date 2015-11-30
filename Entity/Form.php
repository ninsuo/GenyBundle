<?php

namespace GenyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="form")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\FormRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @Serializer\ExclusionPolicy("NONE")
 */
class Form
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     * @Serializer\Exclude
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     * @Serializer\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Serializer\Type("string")
     */
    protected $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Field", mappedBy="form", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<GenyBundle\Entity\Field>")
     */
    protected $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }
}
