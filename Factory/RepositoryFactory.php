<?php

namespace GenyBundle\Factory;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RepositoryFactory
{
    public static function getRepository(ContainerInterface $container, $name)
    {
        $repository = $container
           ->get('doctrine')
           ->getRepository($name);

        if ($repository instanceof ContainerAwareInterface) {
            $repository->setContainer($container);
        }

        return $repository;
    }
}
