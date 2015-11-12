<?php

namespace Fuz\GenyBundle\Provider\Extension;

use Fuz\GenyBundle\Data\Resources\Type;
use Fuz\GenyBundle\Data\Resources\Option;
use Fuz\GenyBundle\Data\Resources\Validator;
use Fuz\GenyBundle\Provider\Loader\FileLoader;
use Fuz\GenyBundle\Provider\Unserializer\JsonUnserializer;

class CoreExtension extends AbstractExtension
{
    public function getTypes()
    {
        return array(
            'base' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/base.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'button' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/button.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'checkbox' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/checkbox.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'choice' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/choice.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'collection' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/collection.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'container' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/container.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'form' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/form.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'hash' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/hash.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'list' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/list.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'number' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/number.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'submit' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/submit.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'text' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/text.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'textarea' => new Type(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/types/textarea.json',
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getOptions()
    {
        return array(
            'action' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/action.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'allow_add' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/allow_add.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'allow_delete' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/allow_delete.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'always_empty' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/always_empty.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'attr' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/attr.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'choices' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/choices.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'disabled' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/disabled.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'empty_value' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/empty_value.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'expanded' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/expanded.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'grouping' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/grouping.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'invalid_message' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/invalid_message.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'label' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/label.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'label_attr' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/label_attr.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'max_length' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/max_length.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'method' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/method.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'multiple' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/multiple.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'precision' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/precision.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'preferred_choices' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/preferred_choices.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'read_only' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/read_only.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'required' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/required.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'rounding_mode' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/rounding_mode.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'trim' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/trim.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'value' => new Option(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/options/value.json',
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getValidators()
    {
        return array(
            'choice' => new Validator(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/validators/choice.json',
                JsonUnserializer::FORMAT_JSON
            ),
            'type' => new Validator(
                FileLoader::TYPE_FILE,
                '@FuzGenyBundle/Resources/core/validators/type.json',
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getName()
    {
        return 'core';
    }
}