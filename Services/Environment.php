<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Entity\Form;
use Fuz\GenyBundle\Entity\Type;
use Fuz\GenyBundle\Exception\NormalizerException;

class Environment
{
    const DIR_OPTIONS       = '@FuzGenyBundle/Resources/geny/options';
    const DIR_TYPES         = '@FuzGenyBundle/Resources/geny/types';
    const DIR_VALIDATORS    = '@FuzGenyBundle/Resources/geny/validators';
    const CORE_LOADER       = Loader::TYPE_FILE;
    const CORE_UNSERIALIZER = Unserializer::FORMAT_JSON;

    protected $agent;
    protected $loader;
    protected $unserializer;
    protected $normalizer;
    protected $builder;
    protected $validator;

    public function __construct(Agent $agent, Loader $loader, Unserializer $unserializer, Normalizer $normalizer, Builder $builder, Validator $validator)
    {
        $this->agent        = $agent;
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->validator    = $validator;
    }

    public function load($path)
    {
        if ($this->agent->getForms()->containsKey($path)) {
            return $this->agent->getForms->get($path);
        }

        // 1- Content Loader (fs, db, ...)
        $contents = $this->loader->load('file', $path);

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserializer->unserialize($path, 'json', $contents);

        // 3- Geny Normalizer
        $form = $this->normalizer->normalizeForm($path, $data);

        \Symfony\Component\VarDumper\VarDumper::dump($form);
        \Symfony\Component\VarDumper\VarDumper::dump($this->agent);
        die();


        /*
         *
         *
         * 4- Form builder
         * 5- Form validator
         */

        $this->agent->getForms()->set($path, $form);
        return $form;
    }

    public function normalizeForm($resource, array &$data, array $optionsStack = array(), array $validatorsStack = array())
    {
        if ($this->agent->getForms()->containsKey($resource)) {
            return $this->agent->getForms()->get($resource);
        }

        $form = new Form();
        $form->setResource($resource);

        if (!array_key_exists('type', $data)) {
            throw new NormalizerException(sprintf("Form %s has no type.", $resource));
        }

        $form->setType($this->normalizeType($data['type']));

        if (array_key_exists('name', $data)) {
            $form->setName($data['name']);
        }

        if (array_key_exists('options', $data)) {

            foreach ($data['options'] as $optionName => $parameters) {

                if (!in_array($optionName, $form->getType()->getSupportsOptions())) {
                    throw new NormalizerException(sprintf("Type %s does not support %s option", $form->getType()->getName(), $optionName));
                }

                if (!in_array($optionName, $optionsStack)) {
                    array_push($optionsStack, $optionName);
                    $this->normalizeOption($optionName, $optionsStack);
                    array_pop($optionsStack);
                }

                $this->validator->validate($this->agent->getOptions()->get($optionName), $parameters);

            }
        }

        $this->agent->getForms()->set($resource, $form);
        return $form;
    }

    public function normalizeType($typeName, array $parents = array())
    {
        if ($this->agent->getTypes()->containsKey($typeName)) {
            return $this->agent->getTypes()->get($typeName);
        }

        $realpath = self::DIR_TYPES.'/'.$typeName.'.'.self::CORE_UNSERIALIZER;
        $contents = $this->loader->load(self::CORE_LOADER, $realpath);
        $data     = $this->unserializer->unserialize($realpath, self::CORE_UNSERIALIZER, $contents);

        $type = new Type();

        if (!array_key_exists('name', $data)) {
            throw new NormalizerException("Type %s exists, but do not contain the name field.");
        }

        if ($typeName !== $data['name']) {
            throw new NormalizerException("Type %s exists, but doesn't contain a valid name (%s).", $typeName, $data['name']);
        }

        $type->setName($typeName);

        $parents[] = $typeName;

        if (array_key_exists('parent', $data)) {
            if (in_array($data['parent'], $parents)) {
                throw new NormalizerException(sprintf("Parent-child hierarchy loop in %s -> %s", implode(' -> ', $parents), $typeName));
            }

            $parent = $this->normalizeType($data['parent'], $parents);

            $type->setSupportsOptions($parent->getSupportsOptions());
            $type->setSupportsValidators($parent->getSupportsValidators());
        }

        if (array_key_exists('supports_options', $data)) {
            $type->setSupportsOptions(array_merge(
                  $type->getSupportsOptions(), $data['supports_options']
            ));
        }

        if (array_key_exists('supports_validators', $data)) {
            $type->setSupportsValidators(array_merge(
                  $type->getSupportsValidators(), $data['supports_validators']
            ));
        }

        $this->agent->getTypes()->set($typeName, $type);
        return $type;
    }

    public function normalizeOption($optionName, array $optionsStack)
    {
        if ($this->agent->getOptions()->containsKey($optionName)) {
            return $this->agent->getOptions()->get($optionName);
        }

        $realpath = self::DIR_OPTIONS.'/'.$optionName.'.'.self::CORE_UNSERIALIZER;
        $contents = $this->loader->load(self::CORE_LOADER, $realpath);
        $data     = $this->unserializer->unserialize($realpath, self::CORE_UNSERIALIZER, $contents);
        $option   = $this->normalizeForm($realpath, $data, $optionsStack);

        $this->agent->getOptions()->set($optionName, $option);
        return $option;
    }

}
