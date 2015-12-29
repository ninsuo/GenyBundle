<?php

namespace GenyBundle\Constraint;

class RegexesConstraint implements ConstraintInterface
{
    public function getDefault(Field $entity)
    {
        return [];
    }

    public function normalize(Field $entity)
    {
        $normalized = [];
        $constraints = $entity->getconstraints();

        if (array_key_exists('regexes', $constraints)) {
            foreach ($constraints['regexes'] as $regex) {
                $normalized[] = new Assert\Regex($regex);
            }
        }

        return $normalized;
    }

    public function getBuilder(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('regexes', Type\CollectionType::class, [
               'entry_type'    => Type\TextType::class,
               'entry_options' => [
                   'label' => 'geny.builders.constraint.regexes.pattern',
                   'constraints' => [
                        new Assert\Callback([
                            'callback' => function ($data, ExecutionContextInterface $context) {
                                if (false === @preg_match(sprintf("/%s/", $data), "")) {
                                    $context
                                        ->buildViolation($this->get('translator')->trans('geny.builders.constraint.regexes.error', [], 'geny'))
                                        ->atPath('expression')
                                        ->addViolation();
                                }
                            }
                        ]),
                   ],
               ],
               'label' => 'geny.builders.constraint.regexes',
               'allow_add'    => true,
               'allow_delete' => true,
               'prototype'    => true,
               'required'     => false,
               'delete_empty' => true,
               'attr' => [
                   'class' => 'geny-collection',
               ],
           ]);

        return $this;
    }
}
