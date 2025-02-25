<?php declare(strict_types=1);

use Arc\Framework\App;
use Arc\Framework\Autoloader;

require_once __DIR__ . '/../lib/arc/Framework/Autoloader.php';

Autoloader::registerNamespaces([
    'Arc\\' => realpath(__DIR__ . '/../lib/arc'),
    'Org\\' => realpath(__DIR__ . '/../src'),
]);

$config = require __DIR__ . '/../config/web.php';

(new App($config))->run();
