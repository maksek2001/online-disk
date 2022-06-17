<?php

namespace uses\libs\storage;

use uses\libs\storage\classes\StorageFile;

/**
 * Класс для работы с файловым хранилищем
 * @author Spirkov Maksim
 */
class Storage
{

    /** @var string Абсолютный путь до директории, в которую будет происходит запись файлов*/
    public $location;

    function __construct($location)
    {
        $this->location = $this->prepareDirectoryPath($location);
    }

    /**
     * Получение полного пути до файла
     */
    public function getFullFilePath(string $filePath): string
    {
        $filePath = $this->prepareDirectoryPath($filePath);
        $filePath = str_replace(['?', '<', '>', '"', '*', ':'], '', $filePath);

        return $this->location . DIRECTORY_SEPARATOR . $filePath;
    }

    /**
     * Подготовка пути до директории
     */
    public function prepareDirectoryPath(string $directoryPath): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $directoryPath);
    }

    /**
     * Загрузка файла
     */
    public function uploadFile(StorageFile $file): bool
    {
        $fileDirectory = $file->getDirectoryPath();
        $fileLocation = $this->location;

        if ($fileDirectory != '') {
            $fileDirectory = $this->prepareDirectoryPath($fileDirectory);
            $fileLocation = $fileLocation . DIRECTORY_SEPARATOR . $fileDirectory;
        }

        if (!file_exists($fileLocation)) {
            mkdir($fileLocation, 0740, true);
        }

        if (!is_dir($fileLocation)) {
            return false;
        }

        $filePath = $this->getFullFilePath($file->getFullPath());

        if (file_put_contents($filePath, $file->getContent()) !== false)
            return true;

        return false;
    }

    /**
     * Получение содержимого файла
     * @return string|null
     */
    public function getFileContent(string $filePath)
    {
        if (!$this->exists($filePath)) {
            return null;
        }

        $filePath = $this->getFullFilePath($filePath);

        $fileContent = file_get_contents($filePath);

        return $fileContent ? $fileContent : null;
    }

    /**
     * Проверка файла на существование
     */
    public function exists(string $filePath): bool
    {
        $filePath = $this->getFullFilePath($filePath);

        return file_exists($filePath) && is_file($filePath);
    }

    /**
     * Удаление файла
     */
    public function deleteFile(string $filePath): bool
    {
        return $this->exists($filePath) ? unlink($this->getFullFilePath($filePath)) : false;
    }
}
