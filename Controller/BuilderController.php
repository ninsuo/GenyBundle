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
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
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
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.form')->retrieveForm($id);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $form = $this->getBuilder(sprintf("geny-form-%d", $id), FormBuilderType::class, [], $entity)->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.form')->saveForm($entity);
        }

        $context = [
            'id' => $id,
            'form' => $form->createView(),
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {

            // @TODO can't tab on fields, remove and use same way as fields
            return new JsonResponse([
               'form' => $this->get('templating')->render('GenyBundle:Builder:form.html.twig', $context),
            ]);
        }

        return $context;
    }

    /**
     * Renders one form field editor (name, label, help & required options).
     *
     * @Route(
     *     "/builder/field/{formId}/{fieldId}",
     *     name = "geny_builder_field",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
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
     * Renders one readonly field, so user can directly preview how
     * it will look like.
     *
     * @Route(
     *     "/builder/field-preview/{formId}/{fieldId}",
     *     name = "geny_builder_field_preview",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldPreviewAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $builder = $this->get('geny.builder')->getbuilder($entity->getType());
        $form = $this->getBuilder(sprintf("geny-preview-%d", $fieldId), Type\FormType::class, [], null);
        $form->add($builder->getDataType($entity->getName(), $entity->getOptions(), $entity->getData()));

        return [
            'entity' => $entity,
            'field' => $form->getForm()->createView(),
        ];
    }

    /**
     * @Route(
     *     "/builder/field-details/{formId}/{fieldId}",
     *     name = "geny_builder_field_details",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldDetailsAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $form = $this
           ->getBuilder(sprintf("geny-field-%d", $fieldId), FieldBuilderType::class, [], $entity)
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        $context = [
            'entity'  => $entity,
            'form'    => $form->createView(),
            'formId'  => $formId,
            'fieldId' => $fieldId,
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {

            $json = [];

            if ($form->isValid()) {
                $json['preview'] = $this->forward('GenyBundle:Builder:fieldPreview', $context)->getContent();
                $json['default'] = json_decode($this->forward('GenyBundle:Builder:fieldDefault', $context)->getContent())->default;
            } else {
                $json['details'] = $this->get('templating')->render('GenyBundle:Builder:fieldDetails.html.twig', $context);
            }

            return new JsonResponse($json);
        }

        return $context;
    }

    /**
     * @Route(
     *     "/builder/field-default/{formId}/{fieldId}",
     *     name = "geny_builder_field_default",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldDefaultAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }

        $builder = $this->get('geny.builder')->getbuilder($entity->getType());
        $formBuilder = $this->getBuilder(sprintf("geny-default-%d", $fieldId), Type\FormType::class, [], null);
        $formBuilder->add($builder->getDataType($entity->getName(), $entity->getOptions(), $entity->getData()));

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            if (array_key_exists($entity->getName(), $form->getData())) {
                $data = $form->getData()[$entity->getName()];
            } else {
                $data = $builder->getDefaultData();
            }
            $entity->setData($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        $context = [
            'entity' => $entity,
            'form' => $form->createView(),
            'formId'  => $formId,
            'fieldId' => $fieldId,
        ];

        $json = [];

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            if ($form->isValid()) {
                $json['preview'] = $this->forward('GenyBundle:Builder:fieldPreview', $context)->getContent();
            } else {
                $json['default'] = $this->get('templating')->render('GenyBundle:Builder:fieldDefault.html.twig', $context);
            }

            return new JsonResponse($json);
        }

        return $context;
    }

   /**
     * @Route(
     *     "/builder/field-options/{formId}/{fieldId}",
     *     name = "geny_builder_field_options",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldOptionsAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }




        return [
            'entity'  => $entity,
            'formId'  => $formId,
            'fieldId' => $fieldId,
        ];
    }

   /**
     * @Route(
     *     "/builder/field-validation/{formId}/{fieldId}",
     *     name = "geny_builder_field_validation",
     *     requirements = {
     *         "formId"  = "^\d+$",
     *         "fieldId" = "^\d+$",
     *     }
     * )
     * @Template()
     */
    public function fieldValidationAction(Request $request, $formId, $fieldId)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw $this->createNotFoundException();
        }




        return [
            'entity'  => $entity,
            'formId'  => $formId,
            'fieldId' => $fieldId,
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
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
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

        if (!$this->isFragment($request) && $this->isAjax($request)) {
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
