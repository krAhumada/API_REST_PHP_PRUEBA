<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit75a39ba54f6c8129a5e96b6f116e1c87
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

        spl_autoload_register(array('ComposerAutoloaderInit75a39ba54f6c8129a5e96b6f116e1c87', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit75a39ba54f6c8129a5e96b6f116e1c87', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit75a39ba54f6c8129a5e96b6f116e1c87::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}