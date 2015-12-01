<?php

namespace GenyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="geny_type")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\TypeRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @Serializer\ExclusionPolicy("NONE")
 */
class Type
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    protected $id;

    /**
     * @var Field
     *
     * @ORM\OneToOne(targetEntity="Field", inversedBy="type")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="cascade")
     * @Serializer\Exclude
     */
    protected $field;

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
     * @var array
     *
     * @ORM\Column(name="data", type="json_array")
     * @Assert\Type("array")
     * @Serializer\Type("array")
     */
    protected $data;

    /**
     * @var array
     *
     * @ORM\Column(name="options", type="json_array")
     * @Assert\Type("array")
     * @Serializer\Type("array")
     */
    protected $options;

    /**
     * @var array
     *
     * @ORM\Column(name="constraints", type="json_array")
     * @Assert\Type("array")
     * @Serializer\Type("array")
     */
    protected $constraints;

    public function __construct()
    {
        $this->data        = array();
        $this->options     = array();
        $this->constraints = array();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField(Field $field)
    {
        $this->field = $field;

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

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function setConstraints(array $constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }
}
