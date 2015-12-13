<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
use GenyBundle\Traits\FormTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Request;

class RendererController extends BaseController
{
    use FormTrait;

    /**
     * Renders a form created using the builder.
     *
     * @Route(
     *     "/renderer/render/{id}",
     *     name = "geny_renderer_render",
     *     requirements = {
     *         "id" = "^\d+$"
     *     },
     *     condition="request.isMasterRequest() or not request.isXmlHttpRequest()"
     * )
     * @Method({"GET"})
     * @Template()
     */
    public function renderAction($id)
    {
        $entity = $this
           ->getDoctrine()
           ->getRepository('GenyBundle:Form')
           ->find($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $form = $this->getBuilder(sprintf("form-%d", $id), Type\FormType::class, [], null);
        foreach ($entity->getFields() as $field) {
            $builder = $this->get('geny.builder')->getbuilder($field->getType());
            $form->add($builder->getDataType($field->getName(), $field->getOptions(), $field->getData()));
        }

        return [
            'entity' => $entity,
            'form' => $form->getForm()->createView(),
        ];
    }
}
