<?php

namespace GenyBundle\Twig\Extension;

use GenyBundle\Base\BaseTwigExtension;

class GenyExtension extends BaseTwigExtension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_geny', [$this, 'form_geny'], ['is_safe' => ['html']]),
        ];
    }

    public function form_geny($id)
    {
        return $this
           ->get('templating')
           ->render('GenyBundle:Renderer:render.html.twig', [
               'entity' => $this->get('geny')->getEntity($id),
               'form'   => $this->get('geny')->getForm($id)->createView(),
        ]);
    }

    public function getName()
    {
        return 'geny';
    }
}