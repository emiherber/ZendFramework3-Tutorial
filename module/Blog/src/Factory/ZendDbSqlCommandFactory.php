<?php

namespace Blog\Factory;

/**
 * Description of ZendDbSqlCommandFactory
 *
 * @author emi
 */
use Interop\Container\ContainerInterface;
use Blog\Model\ZendDbSqlCommand;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ZendDbSqlCommandFactory implements FactoryInterface {

    function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new ZendDbSqlCommand($container->get(AdapterInterface::class));
    }

}
