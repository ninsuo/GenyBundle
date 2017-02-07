<?php

namespace GenyBundle\Constraint;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use GenyBundle\Entity\Field;

class UrlConstraint implements ConstraintInterface
{
    public function getDefaults(Field $entity)
    {
        return [
            'url_protocols' => "http\nhttps",
            'url_check_dns' => false,
        ];
    }

    public function normalize(Field $entity)
    {
        $defaults = $this->getDefaults($entity);
        $constraints = $entity->getConstraints();

        $protocols = explode("\n", $defaults['url_protocols']);
        if (isset($constraints['url_protocols'])) {
            $protocols = explode("\n", $constraints['url_protocols']);
        }

        $checkDns = $defaults['url_check_dns'];
        if (isset($constraints['url_check_dns'])) {
            $checkDns = $constraints['url_check_dns'];
        }

        return [
            new Assert\Url([
                'protocols' => $protocols,
                'checkDNS' => $checkDns,
            ]),
        ];
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('url_protocols', Type\TextareaType::class, [
               'required' => false,
               'label' => 'geny.builders.constraint.url.protocols.label',
               'attr' => [
                   'help_text' => 'geny.builders.constraint.url.protocols.help',
               ],
           ])
           ->add('url_check_dns', Type\CheckboxType::class, [
               'required' => false,
               'label' => 'geny.builders.constraint.url.check_dns.label',
               'attr' => [
                   'help_text' => 'geny.builders.constraint.url.check_dns.help',
               ],
           ])
       ;
    }
}
