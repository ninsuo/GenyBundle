<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
use GenyBundle\Traits\FormTrait;
use GenyBundle\Form\Type\FieldBuilderType;
use GenyBundle\Form\Type\FormBuilderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints;

class BuilderController extends BaseController
{
    use FormTrait;

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

        $entity = $this->get('geny.repository.form')->retrieveForm($id);

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
     *     "/builder/form/{id}",
     *     name = "geny_builder_form",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function formAction(Request $request, $id)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.form')->retrieveForm($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(FormBuilderType::class, $entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.form')->saveForm($entity);
        }

        return [
            'id' => $id,
            'form' => $form->createView(),
        ];
    }

    /**
     * Renders one form field editor.
     *
     * @Route(
     *     "/builder/field/{formId}/{fieldId}",
     *     name = "geny_builder_field",
     *     requirements = {
     *         "form_id"  = "^\d+$",
     *         "field_id" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldAction(Request $request, $formId, $fieldId)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        return [
            'entity' => $entity,
        ];
    }

    /**
     * Renders one field, so user can directly preview how
     * it will look like.
     *
     * @Route(
     *     "/builder/field-preview/{formId}/{fieldId}",
     *     name = "geny_builder_field_preview",
     *     requirements = {
     *         "form_id"  = "^\d+$",
     *         "field_id" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldPreviewAction(Request $request, $formId, $fieldId)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $builder = $this->get('geny.builder')->getbuilder($entity->getType());
        $form = $this->getBuilder(sprintf("read-only-%d", $fieldId), Type\FormType::class, [], null);
        $form->add($builder->getDataType($entity->getName(), $entity->getOptions(), $entity->getData()));

        return [
            'entity' => $entity,
            'field' => $form->getForm()->createView(),
        ];
    }

    /**
     * Renders the field details form.
     *
     * @Route(
     *     "/builder/field-details/{formId}/{fieldId}",
     *     name = "geny_builder_field_details",
     *     requirements = {
     *         "form_id"  = "^\d+$",
     *         "field_id" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldDetailsAction(Request $request, $formId, $fieldId)
    {
        if ('/_fragment' !== $request->getPathInfo() && !$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $form = $this
           ->getBuilder(sprintf("field-%d", $fieldId), FieldBuilderType::class, [], $entity)
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        $context = [
            'entity' => $entity,
            'form' => $form->createView(),
        ];

        if ('/_fragment' !== $request->getPathInfo() && $request->isXmlHttpRequest()) {

            $json = [
                'details' => $this->get('templating')->render('GenyBundle:Builder:fieldDetails.html.twig', $context),
            ];

            if ($form->isValid()) {
                $json['readonly'] = $this->forward('GenyBundle:Builder:fieldPreview', [
                    'formId' => $formId,
                    'fieldId' => $fieldId,
                ])->getContent();
            }

            return new JsonResponse($json);
        }

        return $context;
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

        $entity = $this->get('geny.repository.form')->retrieveForm($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $types = array();
        foreach ($this->get('geny.builder')->getBuilders() as $builder) {
            $types[$builder->getDescription()] = $builder->getName();
        }

        $form = $this
           ->createFormBuilder()
           ->add('type', Type\ChoiceType::class, [
               'choices' => $types,
               'choices_as_values' => true,
               'constraints' => [
                   new Constraints\Choice(['choices' => $types]),
               ],
               'label' => 'geny.type.form.add_field.label',
               'required' => false,
               'translation_domain' => 'geny',
           ])
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.field')->createField($entity, $form->getData()['type']);
        }

        $addField = $this->get('templating')->render('GenyBundle:Builder:addField.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
        ]);

        if ('/_fragment' !== $request->getPathInfo() && $request->isXmlHttpRequest()) {
            $renderFields = $this
               ->get('templating')
               ->render('GenyBundle:Builder:fields.html.twig', [
                   'entity' => $entity,
               ]);

            return new JsonResponse([
                'add-field' => $addField,
                'fields' => $renderFields,
            ]);
        }

        return new Response($addField);
    }
}
