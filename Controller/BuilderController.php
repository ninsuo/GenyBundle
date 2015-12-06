<?php

namespace GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type;
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
     *     "/builder/main-form/{id}",
     *     name = "geny_builder_main_form",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function mainFormAction(Request $request, $id)
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

        $form = $this->createForm(BuilderType::class, $entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this
               ->getDoctrine()
               ->getRepository('GenyBundle:Form')
               ->saveForm($entity);
        }

        return [
            'id'   => $id,
            'form' => $form->createView(),
        ];
    }

    /**
     * Renders the "add field" form.
     *
     * @Route(
     *     "/builder/add-field/{id}",
     *     name = "geny_builder_add_field",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function addFieldAction(Request $request, $id)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $types = array();
        foreach ($this->get('geny.type')->getTypes() as $type) {
            $types[$type->getDescription()] = $type->getName();
        }

        $form = $this
           ->createFormBuilder()
           ->add('type', Type\ChoiceType::class, array(
               'choices'            => $types,
               'choices_as_values'  => true,
               'required'           => false,
               'label'              => 'geny.builder.add_field.label',
               'translation_domain' => 'geny',
           ))
           ->getForm();


//        $entity = $this
//           ->getDoctrine()
//           ->getRepository('GenyBundle:Form')
//           ->retrieveForm($id);
//
//        if (is_null($entity)) {
//            throw $this->createNotFoundException();
//        }
//
//        $main = $this->createForm(AddType::class, $entity);
//        $main->handleRequest($request);
//        if ($main->isValid()) {
//            $this
//               ->getDoctrine()
//               ->getRepository('GenyBundle:Form')
//               ->saveForm($entity);
//        }

        return [
            'id'   => $id,
            'form' => $form->createView(),
        ];
    }
}
