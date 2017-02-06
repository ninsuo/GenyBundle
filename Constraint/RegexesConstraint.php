<?php

namespace GenyBundle\Constraint;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegexesConstraint implements ConstraintInterface
{
    public function getDefaults(Field $entity)
    {
        return [];
    }

    public function normalize(Field $entity)
    {
        $normalized = [];
        $constraints = $entity->getconstraints();

        if (isset($constraints['regexes'])) {
            foreach ($constraints['regexes'] as $regex) {
                $escaped = str_replace('#', '\#', $regex);
                $normalized[] = new Assert\Regex(sprintf('#%s#', $escaped));
            }
        }

        return $normalized;
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('regexes', Type\CollectionType::class, [
               'entry_type' => Type\TextType::class,
               'entry_options' => [
                   'label' => 'geny.builders.constraint.regexes',
                   'constraints' => [
                        new Assert\Callback([
                            'callback' => function ($data, ExecutionContextInterface $context) {
                                $escaped = str_replace('#', '\#', $data);
                                if (false === @preg_match(sprintf('#%s#', $escaped), '')) {
                                    $context
                                        ->buildViolation($this->get('translator')->trans('geny.builders.constraint.regexes.error', [], 'geny'))
                                        ->atPath('expression')
                                        ->addViolation();
                                }
                            },
                        ]),
                   ],
               ],
               'label' => ' ',
               'allow_add' => true,
               'allow_delete' => true,
               'prototype' => true,
               'required' => false,
               'delete_empty' => true,
               'attr' => [
                   'class' => 'geny-collection',
               ],
           ]);
    }
}
