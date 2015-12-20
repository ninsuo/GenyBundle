<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
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

        $type = $this
           ->get('form.factory')
           ->createBuilder(Type\FormType::class)
           ->add('label', Type\TextType::class, [
               'label' => 'Key',
           ])
           ->add('value', Type\TextType::class, [
               'label' => 'Value',
           ])
           ->getType()
        ;

        $form = $this
           ->get('form.factory')
           ->createBuilder(Type\FormType::class)
           ->add('hash', Type\CollectionType::class, [
               'entry_type'    => $type,
               'entry_options' => [],
               'allow_add'     => true,
               'allow_delete'  => true,
               'prototype'     => true,
               'required'      => false,
               'delete_empty'  => true,
               'attr'          => [
                   'class' => sprintf('geny-collection geny-options-%d', $id),
               ],
           ])
           ->getForm()
        ;

        return [
            'form' => $form->createView(),
        ];
    }
}
