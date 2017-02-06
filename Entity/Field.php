<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="geny_field")
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
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     * @Serializer\Type("string")
     */
    protected $position;

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
     * @Assert\NotBlank()
     * @Assert\Length(min = 1, max = 32)
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=32)
     * @Assert\NotBlank()
     * @Assert\Length(min = 1, max = 32)
     * @Serializer\Type("string")
     */
    protected $type;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array", nullable=true)
     * @Serializer\Type("array")
     */
    protected $data = [];

    /**
     * @var array
     *
     * @ORM\Column(name="options", type="json_array", nullable=true)
     * @Assert\Type("array")
     * @Serializer\Type("array")
     */
    protected $options = [];

    /**
     * @var array
     *
     * @ORM\Column(name="constraints", type="json_array", nullable=true)
     * @Assert\Type("array")
     * @Serializer\Type("array")
     */
    protected $constraints = [];

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=160)
     * @Assert\Length(min = 0, max = 160)
     * @Serializer\Type("string")
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(name="help", type="string", length=255, nullable=true)
     * @Assert\Length(min = 0, max = 255)
     * @Serializer\Type("string")
     */
    protected $help;

    /**
     * @var string
     *
     * @ORM\Column(name="required", type="boolean")
     * @Assert\Type("boolean")
     * @Serializer\Type("boolean")
     */
    protected $required = true;

    public function getId()
    {
        return $this->id;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
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

    public function getData()
    {
        if ($this->type == 'checkbox') {
            return (boolean) $this->data;
        } elseif ($this->type == 'textarea' && !$this->data) {
            return ''; // Return an empty string. Error otherwise
        } else {
            return $this->data;
        }
    }

    public function setData($data = null)
    {
        $this->data = $data;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options = null)
    {
        $this->options = $options;

        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function setConstraints(array $constraints = null)
    {
        $this->constraints = $constraints;

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

    public function getHelp()
    {
        return $this->help;
    }

    public function setHelp($help)
    {
        $this->help = $help;

        return $this;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @Serializer\PreSerialize
     */
    public function preSerialize()
    {
        $this->data = array($this->data);
    }

    /**
     * @Serializer\PostSerialize
     * @Serializer\PostDeserialize
     */
    public function postDeserialize()
    {
        $this->data = reset($this->data);
    }
}
