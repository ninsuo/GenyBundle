<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Context;

class Normalizer extends BaseService
{

    protected $context;
    protected $stack = array();

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function normalize(array $array)
    {


    }

}
