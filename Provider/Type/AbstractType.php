<?php

namespace GenyBundle\Provider\Type;

use GenyBundle\Base\BaseService;

abstract class AbstractType extends BaseService implements TypeInterface
{
    public function getDataCoreType($type, $name, array $options = null, array $data = null)
    {
        return $this
            ->get('form.factory')
            ->createNamedBuilder($name, $type, $data ?: $this->getDefaultData(), $options ?: $this->getDefaultOptions());
    }
}
