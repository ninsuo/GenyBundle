<?php

namespace GenyBundle\Provider\Builder;

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

    public function getDataType($name, array $options = null, $data = null)
    {
        $type = $options['type'];
        unset($options['type']);

        // add some options accourding to type

        return $this->getTypeBuilder($name, $type, $options, $data);
    }

    public function getDefaultData()
    {
        return null;
    }

    public function getOptionsType($id, $data)
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
           ->getBuilder(sprintf("options-%d", $id), Type\FormType::class, [], $data)
           ->add('type', Type\ChoiceType::class, [
               'choices'           => $types,
               'choices_as_values' => true,
               'expanded'          => true,
               'label'             => 'Field content',
               'constraints'       => [
                   new Assert\Choice(['choices' => $types]),
                   new Assert\NotBlank(),
               ],
               'required' => true,
           ])
           ->add('trim', Type\CheckboxType::class, [
               'label'       => 'Clear leading and trailing whitespaces',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required' => false,
           ])
           ->getForm();
    }

    public function getDefaultOptions()
    {
        return [
            'type' => Type\TextType::class,
            'trim' => true,
        ];
    }

    public function getConstraintsType($id, $options, $data)
    {

    }

    public function getDefaultConstraints($options, $data = null)
    {
        return [];
    }
}
