<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="field")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\FieldRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @Serializer\ExclusionPolicy("NONE")
 */
class Field
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
     * @var Form
     *
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="fields")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", onDelete="cascade")
     * @Serializer\Exclude
     */
    protected $form;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var Type
     *
     * @ORM\OneToOne(targetEntity="Type", mappedBy="field", cascade={"all"})
     * @Assert\Type(type="GenyBundle\Entity\Type")
     * @Assert\Valid()
     * @Serializer\Type("GenyBundle\Entity\Type")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=128)
     * @Serializer\Type("string")
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(name="hint", type="string", length=128)
     * @Serializer\Type("string")
     */
    protected $hint;

    /**
     * @var string
     *
     * @ORM\Column(name="required", type="boolean")
     * @Serializer\Type("boolean")
     */
    protected $required;

    public function __construct()
    {
        $this->type = new Type();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setForm($form)
    {
        $this->form = $form;
        return $this;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getHint()
    {
        return $this->hint;
    }

    public function setHint($hint)
    {
        $this->hint = $hint;

        return $this;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }
}
