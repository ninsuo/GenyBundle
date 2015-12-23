<?php

namespace GenyBundle\Traits;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

trait ConstraintsTrait
{
    public function addExpressionConstraint(FormBuilderInterface $builder)
    {
        $builder
           ->add('expression', Type\TextareaType::class, [
               'label'       => 'geny.builders.constraint.expression',
               'constraints' => [
                   new Assert\Callback([
                       'callback' => function ($data, ExecutionContextInterface $context) {
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
