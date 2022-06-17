<?php

namespace uses\libs\storage\classes;

/**
 * Класс реализующий "файл хранилища"
 * @author Spirkov Maksim
 */
class StorageFile
{
    /** @var string */
    private $fileName;

    /** @var string */
    private $content;

    /** 
     * @var string путь до директории относительно корневой директории Storage
     */
    private $directoryPath;

    public function __construct($fileName, $content = '', $directoryPath = '')
    {
        $this->fileName = $fileName;
        $this->content = $content;
        $this->directoryPath = $directoryPath;
    }

    public function getDirectoryPath()
    {
        return $this->directoryPath;
    }

    public function getFullPath()
    {
        if ($this->directoryPath != '' && $this->directoryPath != null) {
            return $this->directoryPath . DIRECTORY_SEPARATOR . $this->fileName;
        } else {
            return $this->fileName;
        }
    }

    public function setDirectoryPath($directoryPath)
    {
        $this->directoryPath = $directoryPath;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
