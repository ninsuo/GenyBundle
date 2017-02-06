<?php

namespace GenyBundle\Constraint;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use GenyBundle\Entity\Field;

class EmailConstraint implements ConstraintInterface
{
    public function getDefaults(Field $entity)
    {
        return [
            'email_check_mx' => false,
            'email_check_host' => false,
        ];
    }

    public function normalize(Field $entity)
    {
        $defaults = $this->getDefaults($entity);
        $constraints = $entity->getConstraints();

        $checkMx = $defaults['email_check_mx'];
        if (isset($constraints['email_check_mx'])) {
            $checkMx = $constraints['email_check_mx'];
        }

        $checkHost = $defaults['email_check_host'];
        if (isset($constraints['email_check_host'])) {
            $checkHost = $constraints['email_check_host'];
        }

        return [
            new Assert\Email([
                'checkMX' => $checkMx,
                'checkHost' => $checkHost,
            ]),
        ];
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('email_check_mx', Type\CheckboxType::class, [
               'required' => false,
               'label' => 'geny.builders.constraint.email.check_mx',
               'attr' => [
                   'help_text' => 'geny.builders.constraint.email.check_mx.help',
               ],
           ])
           ->add('email_check_host', Type\CheckboxType::class, [
               'required' => false,
               'label' => 'geny.builders.constraint.email.check_host',
               'attr' => [
                   'help_text' => 'geny.builders.constraint.email.check_host.help',
               ],
           ])
       ;
    }
}
