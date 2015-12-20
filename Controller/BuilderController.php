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

        return [
            'id' => $id,
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
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
        if ($form->isValid()) {
            if (array_key_exists($entity->getName(), $form->getData())) {
                $data = $form->getData()[$entity->getName()];
            } else {
                $builder = $this->get('geny.builder')->getBuilder($entity->getType());
                $data = $builder->getDefaultData();
            }
            $entity->setData($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        $context = [
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'     => $id,
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

        $entity = $this->get('geny')->getFieldEntity($id);


        $builder = $this->get('geny.builder')->getBuilder($entity->getType());




        return [
            'entity' => $entity,
            'id'     => $id,
        ];
    }

    /**
     * @Route(
     *     "/builder/field-validation/{id}",
     *     name = "geny_builder_field_validation",
     *     requirements = {
     *         "id"  = "^\d+$"
     *     }
     * )
     * @Template()
     */
    public function fieldValidationAction(Request $request, $id)
    {
        if (!$this->isFragment($request) && !$this->isAjax($request)) {
            throw $this->createNotFoundException();
        }

        $entity = $this->get('geny')->getFieldEntity($id);



        return [
            'entity' => $entity,
            'id'     => $id,
        ];
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

        $entity =  $this->get('geny')->getFormEntity($id);

        $types = array();
        foreach ($this->get('geny.builder')->getBuilders() as $builder) {
            $types[$builder->getDescription()] = $builder->getName();
        }

        $form = $this
           ->createFormBuilder()
           ->add('type', Type\ChoiceType::class, [
               'choices'            => $types,
               'choices_as_values'  => true,
               'constraints'        => [
                   new Constraints\Choice(['choices' => $types]),
               ],
               'label'              => 'geny.type.form.add_field.label',
               'required'           => false,
               'translation_domain' => 'geny',
           ])
           ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('geny.repository.field')->createField($entity, $form->getData()['type']);
        }

        $addField = $this->get('templating')->render('GenyBundle:Builder:addField.html.twig', [
            'id'   => $id,
            'form' => $form->createView(),
        ]);

        if (!$this->isFragment($request) && $this->isAjax($request)) {
            $renderFields = $this->get('templating')->render('GenyBundle:Builder:fields.html.twig', [
                'entity' => $entity,
            ]);

            return new JsonResponse([
                'add-field' => $addField,
                'fields'    => $renderFields,
            ]);
        }

        return new Response($addField);
    }
}
