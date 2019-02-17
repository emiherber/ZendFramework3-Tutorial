<?php

namespace Blog\Factory;

/**
 * Description of ListControllerFactory
 *
 * @author emi
 */
use Blog\Controller\ListController;
use Blog\Model\PostRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListControllerFactory implements FactoryInterface{
    /**
     * 
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ListController
     */
    function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new ListController($container->get(PostRepositoryInterface::class));
    }
}
