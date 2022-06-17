<?php

namespace uses\libs\config;

use yii\console\Exception as ConsoleException;

/**
 * Загрузчик конфигурации из php файла.
 */
class GetConfig
{
    protected static $_configPath = '\\uses\\config\\';

    public static function get($fileName)
    {
        if ($fileName === '' || $fileName == null) {
            throw new ConsoleException('Config file is not specified');
        }

        $file = $_SERVER['DOCUMENT_ROOT'] . static::$_configPath . $fileName . '.php';
        
        if (!is_file($file)) {
            throw new ConsoleException('Config file «' . $file . '» is not found');
        }

        $config = include($file);

        if (!isset($config) || !is_array($config)) {
            throw new ConsoleException('This file is not contains the array of the configuration');
        }

        return $config;
    }
}
