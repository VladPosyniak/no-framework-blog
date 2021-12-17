<?php
namespace Tests;

use DI\Container;
use DI\ContainerBuilder;

trait TestHelper
{
    protected function getDI(): Container
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAnnotations(false);
        $containerBuilder->addDefinitions(require CONFIG_PATH . '/definitions.php');
        return $containerBuilder->build();
    }

    protected function setConfig(): void
    {
        require_once dirname(__DIR__) . '/config/env.php';
    }
}