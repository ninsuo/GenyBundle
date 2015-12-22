<?php

namespace GenyBundle\Traits;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

trait OptionsTrait
{
    public function addTrimOption(FormBuilderInterface $builder)
    {
        $builder
           ->add('trim', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.trim',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);

        return $this;
    }

    public function addReadonlyOption(FormBuilderInterface $builder)
    {
        $builder
           ->add('readonly', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.readonly',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);

        return $this;
    }

    public function addDisabledOption(FormBuilderInterface $builder)
    {
        $builder
           ->add('disabled', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.disabled',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);

        return $this;
    }
}
