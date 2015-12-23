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
        $name        = $entity->getName();
        $data        = $entity->getData();
        $options     = $this->normalizeOptions($entity);
        $options['constraints'] = $this->normalizeConstraints($entity);

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

    public function normalizeOptions(Field $entity)
    {
        $options = $entity->getOptions();

        if ($options['readonly']) {
            $options['attr']['readonly'] = $options['readonly'];
        }
        unset($options['readonly']);

        return $options;
    }

    public function getConstraintsType(Field $entity, $data)
    {
        $builder = $this
            ->getBuilder(sprintf("constraints-%d", $entity->getId()), Type\FormType::class, [
                'translation_domain' => 'geny',
            ], $data);

        $this
           ->addRegexesConstraint($builder)
           ->addExpressionConstraint($builder);

        return $builder;
    }

    public function getDefaultConstraints()
    {
        return [
            'regexes' => [],
            'expression' => null,
        ];
    }

    public function normalizeConstraints(Field $entity)
    {
        $constraints = $entity->getConstraints();
        $normalized = [];

        foreach ($constraints['regexes'] as $regex) {
            $normalized[] = new Assert\Regex($regex);
        }

        if ($constraints['expression']) {
            $normalized[] = new Assert\Expression($constraints['expression']);
        }

        return $normalized;
    }
}
