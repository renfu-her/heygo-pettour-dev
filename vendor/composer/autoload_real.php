<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitaf13b0156e2cc57bfb09a9d69acff17d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitaf13b0156e2cc57bfb09a9d69acff17d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitaf13b0156e2cc57bfb09a9d69acff17d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitaf13b0156e2cc57bfb09a9d69acff17d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
