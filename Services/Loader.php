<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\HttpKernel\Config\FileLocator;
use Fuz\GenyBundle\Exception\LoaderException;

class Loader
{
    const TYPE_FILE = 'file';

    protected $locator;

    public function __construct(FileLocator $locator)
    {
        $this->locator = $locator;
    }

    public function load($type, $resource)
    {
        switch ($type) {
            case self::TYPE_FILE:
                $realpath = $this->locator->locate($resource);
                $contents = file_get_contents($realpath);
                if (false === $contents) {
                    throw new LoaderException(sprintf("Unable to open or read file: %s", $realpath));
                }
                break;
            default:
                throw new LoaderException(sprintf("Loader %s is not implemented.", $type));
        }
        return $contents;
    }

}
