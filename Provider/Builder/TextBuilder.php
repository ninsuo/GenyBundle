<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

        $type = $options['type'];
        unset($options['type']);

        // add some options accourding to type

        return $this->getBuilder($name, $type, $options, $data);
    }

    public function getDefaultData()
    {
        return null;
    }

    public function getOptionsType(Field $entity, $data)
    {
        // TODO PUT TRANSLATIONS IN THE OTHER FILE

        $types = [
            'Free text' => Type\TextType::class,
            'Email'     => Type\EmailType::class,
            'Url'       => Type\UrlType::class,
            'Number'    => Type\NumberType::class,
            'Password'  => Type\PasswordType::class,
            'Percent'   => Type\PercentType::class,
        ];

        return $this
            ->getBuilder(sprintf("options-%d", $entity->getId()), Type\FormType::class, [
                'constraints' => [
                    new Assert\Callback([
                        'callback' => function($data, ExecutionContextInterface $context) use ($entity) {
                           if ($entity->getOptions()['type'] !== $data['type']) {
                               $entity->setData($this->getDefaultData());
                           }
                        },
                    ]),
                ],
            ], $data)
            ->add('type', Type\ChoiceType::class, [
                'choices'           => $types,
                'choices_as_values' => true,
                'expanded'          => true,
                'label'             => 'Field content',
                'constraints'       => [
                    new Assert\Choice(['choices' => $types]),
                    new Assert\NotBlank(),
                ],
                'required'          => true,
            ])
            ->add('trim', Type\CheckboxType::class, [
                'label'       => 'Clear leading and trailing whitespaces',
                'constraints' => [
                    new Assert\Type(['type' => 'bool']),
                ],
                'required'    => false,
            ]);
    }

    public function getDefaultOptions()
    {
        return [
            'type' => Type\TextType::class,
            'trim' => true,
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
