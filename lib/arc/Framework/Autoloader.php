<?php declare(strict_types=1);

namespace Arc\Framework;

class Autoloader
{
    private static array $namespaces = [];

    public static function registerNamespaces(array $namespaces): void
    {
        self::$namespaces = $namespaces;

        spl_autoload_register([self::class, 'load']);
    }

    private static function load(string $className): void
    {
        foreach (self::$namespaces as $namespace => $path) {
            if (str_starts_with($className, $namespace)) {
                $classPath = substr($className, strlen($namespace));
                $classPath = str_replace('\\', '/', $classPath);
                $finalPath = rtrim($path, '/') . '/' . $classPath . '.php';

                if (file_exists($finalPath)) {
                    require_once $finalPath;
                }
            }
        }
    }
}
