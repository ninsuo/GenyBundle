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

        $form = $this->createForm(BuilderType::class, $entity);

        return [
            'form' => $form->createView(),
        ];
    }
}
