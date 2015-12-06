<?php

namespace GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use GenyBundle\Base\BaseController;

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
            throw new $this->createNotFoundException();
        }

        return [
            'entity' => $entity,
        ];
    }
}
