<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
use GenyBundle\Exception\FormNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class RendererController extends BaseController
{
    /**
     * Renders a form created using the builder.
     *
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

        try {
            $entity = $this->get('geny')->getEntity($id);
        } catch (FormNotFoundException $ex) {
            throw $this->createNotFoundException($ex->getMessage());
        }

        $form = $this->get('geny')->getForm($id);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }
}
