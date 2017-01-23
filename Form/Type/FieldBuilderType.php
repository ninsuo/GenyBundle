<?php
namespace GenyBundle\Form\Type;
use GenyBundle\Base\BaseType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
class FieldBuilderType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('name', Type\TextType::class, [
               'attr'       => [
                   'placeholder' => 'geny.type.field.name.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.type.field.name.default', [], 'geny'),
               'label'      => 'geny.type.field.name.label',
               'required'   => true,
               'constraints' => [
                   new Assert\Regex([
                       'pattern' => '#\A[_a-zA-Z0-9]{0,32}\Z#',
                       'message' => $this->get('translator')->trans('geny.type.field.name.error.not_alphanumeric', [], 'geny'),
                   ]),
                   new Assert\Regex([
                       'pattern' => '#\A[_a-zA-Z]#',
                       'message' => $this->get('translator')->trans('geny.type.field.name.error.begin_by_number', [], 'geny'),
                   ]),
                   new Assert\Callback([
                       'callback' => function($data, ExecutionContextInterface $context) {
                            $object = $context->getRoot()->getData();
                            foreach ($object->getForm()->getFields() as $field) {
                                if ($field !== $object && $field->getName() == $data) {
                                    $context->buildViolation($this->get('translator')->trans('geny.type.field.name.error.already_used', [], 'geny'))
                                        ->atPath('name')
                                        ->addViolation();
                                    break ;
                                }
                            }
                       },
                   ]),
               ],
           ])
           ->add('label', Type\TextType::class, [
               'attr'        => [
                   'placeholder' => 'geny.type.field.label.placeholder',
               ],
               'empty_data'  => $this->get('translator')->trans('geny.type.field.label.default', [], 'geny'),
               'label'       => 'geny.type.field.label.label',
               'required'    => true,
           ])
           ->add('help', Type\TextType::class, [
               'label'      => 'geny.type.field.help.label',
               'required'   => false,
           ])
           ->add('required', Type\CheckboxType::class, [
               'label'      => 'geny.type.field.required.label',
               'required'   => false,
           ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'GenyBundle\Entity\Field',
            'translation_domain' => 'geny',
            'help_text' => null,
        ]);
    }
}