<?php

namespace Fuz\GenyBundle\Provider\Loader;

use Symfony\Component\HttpKernel\Config\FileLocator;

class FileLoader implements LoaderInterface
{
    const TYPE_FILE = 'file';

    protected $locator;

    public function __construct(FileLocator $locator)
    {
        $this->locator = $locator;
    }

    public function load($resource)
    {
        $realpath = $this->locator->locate($resource);
        if (!is_readable($realpath)) {
            throw new LoaderException(sprintf("File '%s' is not readable", $realpath));
        }

        $contents = file_get_contents($realpath);
        if (false === $contents) {
            throw new LoaderException(sprintf("Unable to open file: %s", $realpath));
        }

        return $contents;
    }

    public function supports($type)
    {
        return self::TYPE_FILE === strtolower($type);
    }

    public function getName()
    {
        return self::TYPE_FILE;
    }
}
