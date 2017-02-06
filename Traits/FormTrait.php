<?php

namespace GenyBundle\Traits;

trait FormTrait
{
    protected function getBuilder($name, $type, array $options = [], $data = null)
    {
        return $this->get('form.factory')->createNamedBuilder($name, $type, $data, $options);
    }
}
