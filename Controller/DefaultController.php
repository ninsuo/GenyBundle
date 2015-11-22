<?php

namespace Fuz\GenyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Fuz\GenyBundle\Base\BaseController;

class DefaultController extends BaseController
{
    /**
     * @Route("/bob", name="xxx")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    }
}
