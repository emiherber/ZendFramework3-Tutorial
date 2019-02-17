<?php

namespace Blog\Factory;

/**
 * Description of ZendDbSqlRepositoryFactory
 *
 * @author emi
 */
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ReflectionHydrator;
use Zend\Db\Adapter\AdapterInterface;
use Blog\Model\ZendDbSqlRepository;
use Blog\Model\Post;

class ZendDbSqlRepositoryFactory implements FactoryInterface {

    /**
     * 
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ZendDbSqlRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new ZendDbSqlRepository(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator(),
            new Post('', '')
        );
    }

}