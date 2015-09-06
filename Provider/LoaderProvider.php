<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Provider\Loader\LoaderInterface;
use Fuz\GenyBundle\Exception\LoaderException;

class LoaderProvider extends BaseService
{
    protected $loaders = array();

    public function load($type, $resource)
    {
        foreach ($this->loaders as $loader) {
            if ($loader->supports($type)) {
                return $loader->load($resource);
            }
        }

        throw new LoaderException(sprintf("Loader %s is not implemented.", $type));
    }

    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[] = $loader;
    }
}
