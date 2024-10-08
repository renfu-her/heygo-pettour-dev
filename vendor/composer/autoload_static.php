<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf13b0156e2cc57bfb09a9d69acff17d
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Ecpay\\Sdk\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ecpay\\Sdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/ecpay/sdk/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf13b0156e2cc57bfb09a9d69acff17d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf13b0156e2cc57bfb09a9d69acff17d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaf13b0156e2cc57bfb09a9d69acff17d::$classMap;

        }, null, ClassLoader::class);
    }
}
