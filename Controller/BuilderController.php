<?php

namespace GenyBundle\Controller;

use GenyBundle\Base\BaseController;
use GenyBundle\Traits\FormTrait;
use GenyBundle\Form\Type\FieldBuilderType;
use GenyBundle\Form\Type\FormBuilderType;
use GenyBundle\Form\Type\SubmitBuilderType;
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

        $entity =  $this->get('geny')->getFormEntity($id);

        return [
            'entity' => $entity,
            'id'     => $entity->getId(),
        ];
    }

    /**
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

        $entity =  $this->get('geny')->getFormEntity($id);

        $form = $this->getBuilder(sprintf("geny-form-%d", $id), FormBuilderType::class, [], $entity)->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.form')->saveForm($entity);
        }

        $context = [
            'id'      => $id,
            'form'    => $form->createView(),
            'isValid' => $form->isValid(),
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            $json = [];
            if ($form->isValid()) {
                $json['title']  = $this->forward('GenyBundle:Builder:formTitle', ['id' => $id])->getContent();
                $json['submit'] = $this->forward('GenyBundle:Builder:formSubmit', ['id' => $id])->getContent();
            }
            if (!$form->isValid() || $request->request->get('geny-force-reload')) {
                $json['form'] = $this->get('templating')->render('GenyBundle:Builder:form.html.twig', $context);
            }
            return new JsonResponse($json);
        }

        return $context;
    }

    /**
     * @Route(
     *     "/builder/form-title/{id}",
     *     name = "geny_builder_form_title",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function formTitleAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity =  $this->get('geny')->getFormEntity($id);

        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route(
     *     "/builder/form-preview/{id}",
     *     name = "geny_builder_form_preview",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function formPreviewAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $options = [
            sprintf("form-%d", $id) => [
                'attr' => [
                    'id' => sprintf('geny-form-preview-content-%d', $id),
                ],
            ],
            sprintf("submit-%d", $id) => [
                'attr' => [
                    'class' => 'domajax',
                    'data-endpoint' => $this->generateUrl('geny_builder_form_preview', ['id' => $id]),
                    'data-input' => sprintf('#geny-form-preview-content-%d', $id),
                    'data-lock' => sprintf('#geny-form-preview-content-%d', $id),
                    'data-output' => sprintf('#geny-form-preview-%d', $id),
                ],
            ],
        ];

        $form = $this->get('geny')->getForm($id, $options);
        $form->handleRequest($request);

        $data = null;
        if ($form->isValid()) {
            $data = $form->getData();
        }

        return [
            'id'   => $id,
            'form' => $form->createView(),
            'data' => $data,
        ];
    }

    /**
     * @Route(
     *     "/builder/fields/{id}",
     *     name = "geny_builder_fields",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldsAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity =  $this->get('geny')->getFormEntity($id, false);

        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route(
     *     "/builder/field/{id}",
     *     name = "geny_builder_field",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        return [
            'id' => $id,
        ];
    }

    /**
     * Renders one readonly field, so user can directly preview how
     * it will look like.
     *
     * @Route(
     *     "/builder/field-preview/{id}",
     *     name = "geny_builder_field_preview",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldPreviewAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny')->getFieldEntity($id);
        $field = $this->get('geny')->getField($id);

        $form = $this->getBuilder(sprintf("geny-preview-%d", $id), Type\FormType::class, [], null);
        $form->add($field);

        return [
            'entity' => $entity,
            'form'   => $form->getForm()->createView(),
        ];
    }

    /**
     * @Route(
     *     "/builder/field-details/{id}",
     *     name = "geny_builder_field_details",
     *     requirements = {
     *         "id"  = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldDetailsAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny')->getFieldEntity($id);

        $form = $this
           ->getBuilder(sprintf("geny-field-%d", $id), FieldBuilderType::class, [], $entity)
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.field')->saveField($entity);
        }

        $builder = $this->get('geny.builder')->getBuilder($entity->getType());

        $context = [
            'builder' => $builder,
            'entity'  => $entity,
            'form'    => $form->createView(),
            'id'      => $id,
            'isValid' => $form->isValid(),
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {

            $json = [];

            if ($form->isValid()) {
                $json['preview'] = $this->forward('GenyBundle:Builder:fieldPreview', $context)->getContent();
                $json['default'] = json_decode($this->forward('GenyBundle:Builder:fieldDefault', $context)->getContent())->default;
            }
            if (!$form->isValid() || $request->request->get('geny-force-reload')) {
                $json['details'] = $this->get('templating')->render('GenyBundle:Builder:fieldDetails.html.twig', $context);
            }

            return new JsonResponse($json);
        }

        return $context;
    }

    /**
     * @Route(
     *     "/builder/field-default/{id}",
     *     name = "geny_builder_field_default",
     *     requirements = {
     *         "id"  = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldDefaultAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny')->getFieldEntity($id);
        $field = $this->get('geny')->getField($id);

        $formBuilder = $this->getBuilder(sprintf("geny-default-%d", $id), Type\FormType::class, [], null);
        $formBuilder->add($field);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        $isSubmitted = $form->isSubmitted();
        if ($isSubmitted) {
            if (array_key_exists($entity->getName(), $form->getData())) {
                $data = $form->getData()[$entity->getName()];
            } else {
                $builder = $this->get('geny')->getBuilder($entity);
                $data    = $builder->getDefaultData($entity);
            }
            $entity->setData($data);
            $this->get('geny.repository.field')->saveField($entity);
        }

        $context = [
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'     => $id,
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            if ($isSubmitted) {
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
     *     "/builder/field-options/{id}",
     *     name = "geny_builder_field_options",
     *     requirements = {
     *         "id"  = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldOptionsAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity  = $this->get('geny')->getFieldEntity($id);
        $builder = $this->get('geny')->getBuilder($entity);
        $data    = $this->get('geny')->getOptionsData($builder, $entity);
        $form    = $this->get('geny')->getOptionsType($builder, $entity, $data);

        $form->handleRequest($request);
        $isValid = $form->isValid();

        if ($isValid) {
            $options = $form->getData();
            $entity->setOptions($options);
            $this->get('geny.repository.field')->saveField($entity);
        }

        $context = [
            'entity' => $entity,
            'id'     => $id,
            'form'   => $form->createView(),
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            $json = ['isValid' => $isValid];

            $json['options'] = $this->get('templating')->render('GenyBundle:Builder:fieldOptions.html.twig', $context);
            if ($isValid) {
                $json['preview'] = $this->forward('GenyBundle:Builder:fieldPreview', $context)->getContent();
                $json['default'] = json_decode($this->forward('GenyBundle:Builder:fieldDefault', $context)->getContent())->default;
            }

            return new JsonResponse($json);
        }

        return $context;
    }

    /**
     * @Route(
     *     "/builder/field-constraints/{id}",
     *     name = "geny_builder_field_constraints",
     *     requirements = {
     *         "id"  = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldConstraintsAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity  = $this->get('geny')->getFieldEntity($id);
        $builder = $this->get('geny')->getBuilder($entity);
        $data    = $this->get('geny')->getConstraintsData($builder, $entity);
        $form    = $this->get('geny')->getConstraintsType($builder, $entity, $data);

        $form->handleRequest($request);
        $isValid = $form->isValid();

        if ($isValid) {
            $constraints = $form->getData();
            $entity->setConstraints($constraints);
            $this->get('geny.repository.field')->saveField($entity);
        }

        $context = [
            'entity' => $entity,
            'id'     => $id,
            'form'   => $form->createView(),
        ];

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            $json = ['isValid' => $isValid];

            $json['constraints'] = $this->get('templating')->render('GenyBundle:Builder:fieldConstraints.html.twig', $context);
            if ($isValid) {
                $json['preview'] = $this->forward('GenyBundle:Builder:fieldPreview', $context)->getContent();
                $json['default'] = json_decode($this->forward('GenyBundle:Builder:fieldDefault', $context)->getContent())->default;
            }

            return new JsonResponse($json);
        }

        return $context;
    }

    /**
     * @Route(
     *     "/builder/form-submit/{id}",
     *     name = "geny_builder_form_submit",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function formSubmitAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity =  $this->get('geny')->getFormEntity($id);
        $form = $this->getBuilder(sprintf("geny-submit-form-%d", $id), SubmitBuilderType::class, [], $entity)->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.form')->saveForm($entity);
        }

        $button = $this->getBuilder(sprintf("geny-submit-preview-%d", $id), Type\FormType::class, [], null);
        $button->add($this->getBuilder("submit", Type\SubmitType::class, ['label' => $entity->getSubmit()]));

        $context = [
            'id'     => $id,
            'entity' => $entity,
            'form'   => $form->createView(),
            'button' => $button->getForm()->createView(),
        ];

        return $context;
    }

    /**
     * @Route(
     *     "/builder/field-chooser/{id}",
     *     name = "geny_builder_field_chooser",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldChooserAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $form = $this->getBuilder(sprintf("geny-add-field-%d", $id), Type\FormType::class, [], null);

        $n = 0;
        $categories = array();
        foreach ($this->get('geny.builder')->getBuilders() as $builder) {
            $name    = sprintf('geny-demo-%d-%d', $id, $n++);
            $preview = $this->get('geny.repository.field')->createFilledField($builder, null, $name);

            $form->add(
                $this->get('geny')->getField($preview)
            );

            $categories[$builder->getCategory()][] = [
                'builder' => $builder,
                'name'    => $name,
            ];
        }

        return [
            'id'         => $id,
            'categories' => $categories,
            'form'       => $form->getForm()->createView(),
        ];
    }

  /**
     * @Route(
     *     "/builder/add-field/{id}/{type}",
     *     name = "geny_builder_add_field",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     */
    public function addFieldAction(Request $request, $id, $type)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity =  $this->get('geny')->getFormEntity($id);
        $this->get('geny.repository.field')->createField($entity, $type);

        return $this->forward('GenyBundle:Builder:fields', [
            'id' => $id,
        ]);
    }

    /**
     * @Route(
     *     "/builder/field-move/{id}/{position}",
     *     name = "geny_builder_field_move",
     *     requirements = {
     *         "id" = "^\d+$",
     *         "position" = "^\d+$"
     *     }
     * )
     */
    public function fieldMoveAction(Request $request, $id, $position)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $field = $this->get('geny')->getFieldEntity($id);
        $form  = $field->getForm();

        $this->get('geny.repository.field')->moveTo($form, $field, $position);

        return $this->forward('GenyBundle:Builder:fields', [
            'id' => $form->getId(),
        ]);
    }

    /**
     * @Route(
     *     "/builder/field-delete/{id}",
     *     name = "geny_builder_field_delete",
     *     requirements = {
     *         "id" = "^\d+$"
     *     }
     * )
     */
    public function fieldDeleteAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $field = $this->get('geny')->getFieldEntity($id);
        $form  = $field->getForm();

        $em = $this->getDoctrine()->getManager();
        $em->remove($field);
        $em->flush($field);

        return $this->render('GenyBundle:Builder:fields.html.twig', [
            'entity' => $form,
        ]);
    }
}
