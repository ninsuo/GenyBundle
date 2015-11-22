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
                '@FuzGenyBundle/Resources/core/types/base.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'button' => new Type(
                '@FuzGenyBundle/Resources/core/types/button.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'checkbox' => new Type(
                '@FuzGenyBundle/Resources/core/types/checkbox.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'choice' => new Type(
                '@FuzGenyBundle/Resources/core/types/choice.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'collection' => new Type(
                '@FuzGenyBundle/Resources/core/types/collection.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'container' => new Type(
                '@FuzGenyBundle/Resources/core/types/container.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'form' => new Type(
                '@FuzGenyBundle/Resources/core/types/form.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'hash' => new Type(
                '@FuzGenyBundle/Resources/core/types/hash.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'list' => new Type(
                '@FuzGenyBundle/Resources/core/types/list.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'number' => new Type(
                '@FuzGenyBundle/Resources/core/types/number.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'submit' => new Type(
                '@FuzGenyBundle/Resources/core/types/submit.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'text' => new Type(
                '@FuzGenyBundle/Resources/core/types/text.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'textarea' => new Type(
                '@FuzGenyBundle/Resources/core/types/textarea.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getOptions()
    {
        return array(
            'action' => new Option(
                '@FuzGenyBundle/Resources/core/options/action.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'allow_add' => new Option(
                '@FuzGenyBundle/Resources/core/options/allow_add.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'allow_delete' => new Option(
                '@FuzGenyBundle/Resources/core/options/allow_delete.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'always_empty' => new Option(
                '@FuzGenyBundle/Resources/core/options/always_empty.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'attr' => new Option(
                '@FuzGenyBundle/Resources/core/options/attr.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'choices' => new Option(
                '@FuzGenyBundle/Resources/core/options/choices.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'disabled' => new Option(
                '@FuzGenyBundle/Resources/core/options/disabled.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'empty_value' => new Option(
                '@FuzGenyBundle/Resources/core/options/empty_value.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'expanded' => new Option(
                '@FuzGenyBundle/Resources/core/options/expanded.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'grouping' => new Option(
                '@FuzGenyBundle/Resources/core/options/grouping.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'invalid_message' => new Option(
                '@FuzGenyBundle/Resources/core/options/invalid_message.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'label' => new Option(
                '@FuzGenyBundle/Resources/core/options/label.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'label_attr' => new Option(
                '@FuzGenyBundle/Resources/core/options/label_attr.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'max_length' => new Option(
                '@FuzGenyBundle/Resources/core/options/max_length.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'method' => new Option(
                '@FuzGenyBundle/Resources/core/options/method.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'multiple' => new Option(
                '@FuzGenyBundle/Resources/core/options/multiple.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'precision' => new Option(
                '@FuzGenyBundle/Resources/core/options/precision.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'preferred_choices' => new Option(
                '@FuzGenyBundle/Resources/core/options/preferred_choices.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'read_only' => new Option(
                '@FuzGenyBundle/Resources/core/options/read_only.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'required' => new Option(
                '@FuzGenyBundle/Resources/core/options/required.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'rounding_mode' => new Option(
                '@FuzGenyBundle/Resources/core/options/rounding_mode.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'trim' => new Option(
                '@FuzGenyBundle/Resources/core/options/trim.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'type' => new Option(
                '@FuzGenyBundle/Resources/core/options/type.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'value' => new Option(
                '@FuzGenyBundle/Resources/core/options/value.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getValidators()
    {
        return array(
            'choice' => new Validator(
                '@FuzGenyBundle/Resources/core/validators/choice.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
            'type' => new Validator(
                '@FuzGenyBundle/Resources/core/validators/type.json',
                FileLoader::TYPE_FILE,
                JsonUnserializer::FORMAT_JSON
            ),
        );
    }

    public function getName()
    {
        return 'core';
    }
}
