<?php declare(strict_types=1);

use Arc\Framework\App;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/web.php';

(new App($config))->run();
