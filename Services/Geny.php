<?php

namespace GenyBundle\Services;

use GenyBundle\Base\BaseService;
use GenyBundle\Exception\FormNotFoundException;
use GenyBundle\Exception\FieldNotFoundException;
use GenyBundle\Entity\Form;
use GenyBundle\Entity\Field;
use GenyBundle\Provider\Builder\BuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Geny extends BaseService
{
    protected $cache = [];

    public function getFormEntity($id)
    {
        $entity = $this->get('geny.repository.form')->retrieveForm($id);

        if (is_null($entity)) {
            throw new FormNotFoundException($id);
        }

        return $entity;
    }

    public function getForm($id, array $options = array())
    {
        if ($id instanceof Form) {
            $entity = $id;
            $id     = $entity->getId();
        } else {
            $entity = $this->getFormEntity($id);
        }

        $form = $this->get('form.factory')->createNamedBuilder(
           $formName = sprintf("form-%d", $id),
           Type\FormType::class,
           null,
           array_key_exists($formName, $options) ? $options[$formName] : []
        );

        foreach ($entity->getFields() as $field) {
            $overloadOptions = array_key_exists($name = $field->getName(), $options) ? $options[$name] : [];
            $form->add($this->getField($field, $overloadOptions));
        }

        $form->add($this->get('form.factory')->createNamedBuilder(
           $submitName = sprintf("submit-%d", $id),
           Type\SubmitType::class,
           null,
           array_merge_recursive(
               ['label' => $entity->getSubmit()],
               array_key_exists($submitName, $options) ? $options[$submitName] : []
           )
        ));

        return $form->getForm();
    }

    public function getFieldEntity($id)
    {
        $entity = $this->get('geny.repository.field')->retrieveField($id);

        if (is_null($entity)) {
            throw new FieldNotFoundException($id);
        }

        return $entity;
    }

    public function getField($id, array $overloadOptions = array())
    {
        if ($id instanceof Field) {
            $entity = $id;
            $id     = $entity->getId();
        } else {
            $entity = $this->getFieldEntity($id);
        }

        $name                   = $entity->getName();
        $builder                = $this->getBuilder($entity);
        $options                = $this->getOptionsData($builder, $entity, true);
        $data                   = $entity->getData();
        $options['constraints'] = $this->getConstraintsData($builder, $entity, true);

        return $builder->getDataType($entity, $name, array_merge_recursive($options, $overloadOptions), $data);
    }

    public function getBuilder(Field $entity)
    {
        return $this->get('geny.builder')->getBuilder($entity->getType());
    }

    public function getOptionsData(BuilderInterface $builder, Field $entity, $normalize = false)
    {
        $config  = $entity->getOptions();
        foreach ($builder->supportsOptions($entity) as $optionClass) {
            $option = $this->getCachedObject($optionClass);
            foreach ($option->getDefault($entity) as $key => $value) {
                if (!isset($config[$key])) {
                    $config[$key] = $value;
                }
            }
        }
        $entity->setOptions($config);

        if (!$normalize) {
            return $entity->getOptions();
        }

        $options = [];
        foreach ($builder->supportsOptions($entity) as $optionClass) {
            $option = $this->getCachedObject($optionClass);
            $test   = $option->normalize($entity, $options);
            if (is_array($test)) {
                $options = $test;
            }
        }

        return array_merge_recursive($options, [
            'label'    => $entity->getLabel(),
            'required' => $entity->isRequired(),
            'attr'     => [
                'help_text' => $entity->getHelp(),
            ],
        ]);
    }

    public function getOptionsType(BuilderInterface $builder, Field $entity, $data)
    {
        $type = $this->get('form.factory')->createNamedBuilder(
           sprintf("options-%d", $entity->getId()),
           Type\FormType::class,
           $data,
           ['translation_domain' => 'geny']
        );

        foreach ($builder->supportsOptions($entity) as $optionClass) {
            $option = $this->getCachedObject($optionClass);
            $option->build($type, $entity, $data);
        }

        return $type->getForm();
    }

    public function getConstraintsData(BuilderInterface $builder, Field $entity, $normalize = false)
    {
        $config = $entity->getConstraints();
        foreach ($builder->supportsConstraints($entity) as $constraintClass) {
            $constraint = $this->getCachedObject($constraintClass);
            foreach ($constraint->getDefault($entity) as $key => $value) {
                if (!isset($config[$key])) {
                    $config[$key] = $value;
                }
            }
        }
        $entity->setConstraints($config);

        if (!$normalize) {
            return $entity->getConstraints();
        }

        $constraints = [];
        foreach ($builder->supportsConstraints($entity) as $constraintClass) {
            $constraint = $this->getCachedObject($constraintClass);
            $test       = $constraint->normalize($entity, $constraints);
            if (is_array($test)) {
                $constraints += $test;
            }
        }

        if ($entity->isRequired()) {
            $constraints[] = new Assert\NotBlank();
        }

        return $constraints;
    }

    public function getConstraintsType(BuilderInterface $builder, Field $entity, $data)
    {
        $type = $this->get('form.factory')->createNamedBuilder(
           sprintf("constraints-%d", $entity->getId()),
           Type\FormType::class,
           $data,
           ['translation_domain' => 'geny']
        );

        foreach ($builder->supportsConstraints($entity) as $constraintClass) {
            $constraint = $this->getCachedObject($constraintClass);
            $constraint->build($type, $entity, $data);
        }

        return $type->getForm();
    }

    protected function getCachedObject($class)
    {
        if (array_key_exists($class, $this->cache)) {
            return $this->cache[$class];
        }

        $object = new $class();

        $this->cache[$class] = $object;
        return $object;
    }
}
