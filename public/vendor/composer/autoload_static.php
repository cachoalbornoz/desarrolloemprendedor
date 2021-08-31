<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit342093a5a58207b7586e308c7a58600b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit342093a5a58207b7586e308c7a58600b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit342093a5a58207b7586e308c7a58600b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
