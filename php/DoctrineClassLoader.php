<?php

use Doctrine\Common\ClassLoader;

require dirname(__DIR__) .
    '/3rd_party/doctrine-dbal/lib/Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader('Doctrine', dirname(__DIR__) . '/3rd_party/doctrine-dbal/lib');
$classLoader->register();