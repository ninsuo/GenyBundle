<?php

namespace GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use GenyBundle\Base\BaseController;
use GenyBundle\Form\Type\BuilderType;

class BuilderController extends BaseController
{
    /**
     * Renders a form builder.
     *
     * @Route(
     *     "/builder/render/{id}",
     *     name = "geny_builder_render",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Method({"GET"})
     * @Template()
     */
    public function renderAction(Request $request, $id)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this
           ->getDoctrine()
           ->getRepository('GenyBundle:Form')
           ->retrieveForm($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        return [
            'entity' => $entity,
        ];
    }

    /**
     * Renders the main configuration form.
     *
     * @Route(
     *     "/builder/render/main/{id}",
     *     name = "geny_builder_render_main",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function renderMainAction(Request $request, $id)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this
           ->getDoctrine()
           ->getRepository('GenyBundle:Form')
           ->retrieveForm($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $main = $this->createForm(BuilderType::class, $entity);

        $main->handleRequest($request);
        if ($main->isValid()) {
            $this
               ->getDoctrine()
               ->getRepository('GenyBundle:Form')
               ->saveForm($entity);
        }

        return [
            'entity' => $entity,
            'main'   => $main->createView(),
        ];
    }
}
