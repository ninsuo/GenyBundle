<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
use GenyBundle\Form\Type as CustomType;
use GenyBundle\Traits\FormTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type;

class RendererController extends BaseController
{
    use FormTrait;

    /**
     * @Route(
     *     "/renderer/render/{id}",
     *     name = "geny_renderer_render",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Method({"GET"})
     * @Template()
     */
    public function renderAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny')->getFormEntity($id);

        $form = $this
           ->getBuilder(sprintf('options-%d', $id), Type\FormType::class)
           ->add('type', Type\ChoiceType::class, [
               'choices' => array_flip([
                   'Free text',
                   'Email',
                   'Url',
                   'Number',
                   'Password',
                   'Percent',
               ]),
               'choices_as_values' => true,
               'expanded' => true,
               'label' => 'Field content',
           ])
           ->add('trim', Type\CheckboxType::class, [
               'label' => 'Clear leading and trailing whitespaces',
           ])->getForm();

        /*
        $form = $this
           ->getBuilder(sprintf("options-%d", $id), Type\FormType::class)
           ->add('choices', Type\CollectionType::class, [
               'entry_type'    => CustomType\EntryType::class,
               'entry_options' => [
                   'fields' => [
                       [
                           'name'    => 'label',
                           'type'    => Type\TextType::class,
                           'options' => [
                               'label' => 'Choice label',
                           ],
                       ], [
                           'name'    => 'value',
                           'type'    => Type\TextType::class,
                           'options' => [
                               'label' => 'Choice value',
                           ],
                       ],
                   ],
               ],
               'allow_add'    => true,
               'allow_delete' => true,
               'prototype'    => true,
               'required'     => false,
               'delete_empty' => true,
               'attr' => [
                   'class' => sprintf('geny-simple-collection geny-options-%d', $id),
               ],
           ])
           ->getForm()
        ;
         */

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }
}
