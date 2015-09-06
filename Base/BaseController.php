<?php

namespace Fuz\GenyBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function info($message, array $parameters = array())
    {
        $this->addFlash('info', $this->trans($message, $parameters));
    }

    public function alert($message, array $parameters = array())
    {
        $this->addFlash('alert', $this->trans($message, $parameters));
    }

    public function danger($message, array $parameters = array())
    {
        $this->addFlash('danger', $this->trans($message, $parameters));
    }

    public function success($message, array $parameters = array())
    {
        $this->addFlash('success', $this->trans($message, $parameters));
    }

    public function trans($property, array $parameters = array())
    {
        return $this->container->get('translator')->trans($property, $parameters);
    }
}
