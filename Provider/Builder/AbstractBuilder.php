<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Base\BaseService;

abstract class AbstractBuilder extends BaseService implements BuilderInterface
{
    public function getDataCoreType($type, $name, array $options = null, array $data = null)
    {
        return $this
            ->get('form.factory')
            ->createNamedBuilder($name, $type, $data ?: $this->getDefaultData(), $options ?: $this->getDefaultOptions());
    }
}
