<?php

namespace GenyBundle\Twig\Extension;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use GenyBundle\Base\BaseTwigExtension;

class GenyExtension extends BaseTwigExtension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('geny_form', [$this, 'geny_form'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('geny_dump', [$this, 'geny_dump'], ['is_safe' => ['html']]),
        ];
    }

    public function geny_form($id, $form = null, array $options = array())
    {
        if ($form instanceof FormInterface) {
            $view = $form->createView();
        } elseif ($form instanceof FormView) {
            $view = $form;
        } else {
            $view = $this->get('geny')->getForm($id, $options)->createView();
        }

        return $this
           ->get('templating')
           ->render('GenyBundle:Renderer:render.html.twig', [
               'entity' => $this->get('geny')->getFormEntity($id),
               'form' => $view,
        ]);
    }

    public function geny_dump($data)
    {
        $stream = fopen('php://memory', 'r+b');
        $dumper = new HtmlDumper($stream);
        $cloner = new VarCloner();
        $dumper->dump($cloner->cloneVar($data));
        rewind($stream);

        return stream_get_contents($stream);
    }

    public function getName()
    {
        return 'geny';
    }
}
