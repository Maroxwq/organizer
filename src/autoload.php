<?php declare(strict_types=1);

spl_autoload_register(function (string $className) {
    $parts = explode('\\', $className);
    array_shift($parts);
    $path = realpath(__DIR__ . '/' . implode('/', $parts) . '.php');

    if (!$path || !file_exists($path)) {
        throw new RuntimeException(sprintf('Can not autoload class "%s", path: "%s"', $className, $path));
    }

    require_once $path;
});
