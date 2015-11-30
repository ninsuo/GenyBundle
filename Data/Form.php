<?php

namespace GenyBundle\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="form")
 * @ORM\Entity(repositoryClass="GenyBundle\Repository\FormRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @Serializer\ExclusionPolicy("NONE")
 */
class Form
{
    protected $id;
    protected $name;
    protected $sections;

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

    public function getSections()
    {
        return $this->sections;
    }

    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }
}
