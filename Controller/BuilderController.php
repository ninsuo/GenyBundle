<?php

namespace GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use GenyBundle\Base\BaseController;
use GenyBundle\Entity\Form;
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
     *     "/builder/form-editor/{id}",
     *     name = "geny_builder_form_editor",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function formEditorAction(Request $request, $id)
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
     * Renders one form field editor.
     *
     * @Route(
     *     "/builder/field-editor/{id}",
     *     name = "geny_builder_field_editor",
     *     requirements = {
     *         "form_id"  = "^\d+$",
     *         "field_id" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldEditorAction($formId, $fieldId)
    {
        return [

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
     */
    public function addFieldAction(Request $request, $id)
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

        $types = array();
        foreach ($this->get('geny.type')->getTypes() as $type) {
            $types[$type->getDescription()] = $type->getName();
        }

        $form = $this
           ->createFormBuilder()
           ->add('type', Type\ChoiceType::class, [
               'choices'            => $types,
               'choices_as_values'  => true,
               'constraints'        => [
                   new Constraints\Choice(['choices' => $types])
               ],
               'data'               => '',
               'label'              => 'geny.builder.add_field.label',
               'required'           => false,
               'translation_domain' => 'geny',
           ])
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this
               ->getDoctrine()
               ->getRepository('GenyBundle:Field')
               ->createField($id, $form->getData()['type']);
        }

        $response = $this->render('GenyBundle:Builder:addField.html.twig', [
            'id'   => $id,
            'form' => $form->createView(),
        ]);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'add-field' => $response,
                'fields'    => $this->render('GenyBundle:Builder:renderFields', ['id' => $id]),
            ]);
        }

        return $response;
    }
}
