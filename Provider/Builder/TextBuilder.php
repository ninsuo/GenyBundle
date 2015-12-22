<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class TextBuilder extends AbstractBuilder
{
    public function getName()
    {
        return 'text';
    }

    public function getDescription()
    {
        return 'geny.builders.text.description';
    }

    public function getDataType(Field $entity)
    {
        $name                   = $entity->getName();
        $data                   = $entity->getData();
        $options                = $entity->getOptions();
        $options['constraints'] = $entity->getConstraints();

        if ($options['readonly']) {
            $options['attr']['readonly'] = $options['readonly'];
        }
        unset($options['readonly']);

        return $this->getBuilder($name, Type\TextType::class, $options, $data);
    }

    public function getDefaultData()
    {
        return null;
    }

    public function getOptionsType(Field $entity, $data)
    {
        $builder = $this
            ->getBuilder(sprintf("options-%d", $entity->getId()), Type\FormType::class, [
                'translation_domain' => 'geny',
            ], $data);

        $this
           ->addTrimOption($builder)
           ->addReadonlyOption($builder)
           ->addDisabledOption($builder);

        return $builder;
    }

    public function getDefaultOptions()
    {
        return [
            'trim'     => true,
            'readonly' => false,
            'disabled' => false,
        ];
    }

    public function getConstraintsType(Field $entity, $data)
    {

    }

    public function getDefaultConstraints()
    {
        return [];
    }
}
