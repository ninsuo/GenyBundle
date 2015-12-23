<?php

namespace GenyBundle\Traits;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

trait ConstraintsTrait
{
    public function addRegexesConstraint(FormBuilderInterface $builder)
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

    public function addExpressionConstraint(FormBuilderInterface $builder)
    {
        $builder
           ->add('expression', Type\TextareaType::class, [
               'label'       => 'geny.builders.constraint.expression',
               'constraints' => [
                   new Assert\Callback([
                       'callback' => function ($data, ExecutionContextInterface $context) {
                            if (is_null($data) || '' === $data) {
                                return ;
                            }
                            $eval = new ExpressionLanguage();
                            try {
                                $eval->evaluate($data, [
                                    'value' => 42,
                                ]);
                            } catch (\Exception $ex) {
                                $class = get_class($ex);
                                $context->buildViolation(sprintf("[%s] %s", substr($class, strrpos($class, '\\') + 1), $ex->getMessage()))
                                    ->atPath('expression')
                                    ->addViolation();
                            }
                       },
                   ]),
               ],
               'required'    => false,
               'attr' => [
                   'help_text' => 'geny.builders.constraint.expression.help',
               ],
        ]);

        return $this;
    }

}
