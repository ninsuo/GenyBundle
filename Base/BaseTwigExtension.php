<?php

namespace GenyBundle\Base;

use GenyBundle\Traits\ContainerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

abstract class BaseTwigExtension extends \Twig_Extension implements ContainerAwareInterface
{
    use ContainerTrait;
}
