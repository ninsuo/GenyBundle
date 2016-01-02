<?php

namespace GenyBundle\Constraint;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

        if (isset($constraints['regexes'])) {
            foreach ($constraints['regexes'] as $regex) {
                $normalized[] = new Assert\Regex($regex);
            }
        }

        return $normalized;
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
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
    }
}
