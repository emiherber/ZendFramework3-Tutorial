<?php

namespace Blog\Factory;

/**
 * Description of WriteControllerFactory
 *
 * @author emi
 */
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Blog\Model\PostRepositoryInterface;
use Blog\Controller\WriteController;
use Blog\Model\PostCommandInterface;
use Blog\Form\PostForm;

class WriteControllerFactory implements FactoryInterface {

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return WriteController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new WriteController(
            $container->get(PostCommandInterface::class),
            $formManager->get(PostForm::class),
            $container->get(PostRepositoryInterface::class)
        );
    }

}
