<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit90cc65d23267703a16fa89a4e7a6d6dd
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

        spl_autoload_register(array('ComposerAutoloaderInit90cc65d23267703a16fa89a4e7a6d6dd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit90cc65d23267703a16fa89a4e7a6d6dd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit90cc65d23267703a16fa89a4e7a6d6dd::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
