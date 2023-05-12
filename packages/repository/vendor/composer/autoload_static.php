<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite335dff6ec835d3dc492aa8966a4877e
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tuezy\\Repository\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tuezy\\Repository\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite335dff6ec835d3dc492aa8966a4877e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite335dff6ec835d3dc492aa8966a4877e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite335dff6ec835d3dc492aa8966a4877e::$classMap;

        }, null, ClassLoader::class);
    }
}
