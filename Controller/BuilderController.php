<?php

namespace GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use GenyBundle\Base\BaseController;

class BuilderController extends BaseController
{
    /**
     * @Route("/builder/new", name="geny_builder_new")
     * @Template()
     */
    public function newAction(Request $request)
    {



    }
}
