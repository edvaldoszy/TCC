<?php

namespace Szy\File;

use RuntimeException;
use Serializable;

class File implements Serializable
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     * @throws Exception\FileNotFoundException
     */
    function __construct($path)
    {
        if (FileSystem::isFile($path) === false)
            throw new Exception\FileNotFoundException("No such file {$path}");

        $this->path = $path;
    }

    /**
     * @param string $newname
     * @param bool $overwrite
     * @return File
     * @throws Exception\FileException
     */
    public function copy($newname, $overwrite = false)
    {
        if (FileSystem::exists($newname) && !$overwrite)
            throw new Exception\FileException("File already exists");

        if (FileSystem::rename($this->path, $newname) === false)
            throw new Exception\FileException(error_get_last());

        return new self($newname);
    }

    /**
     * @param string $newname
     * @param bool $overwrite
     * @return bool
     * @throws Exception\FileException
     */
    public function rename($newname, $overwrite = false)
    {
        if (FileSystem::exists($newname) && !$overwrite)
            throw new Exception\FileException("File already exists");

        if (FileSystem::rename($this, $newname) === false)
            throw new Exception\FileException(error_get_last());

        $this->path = $newname;
        return true;
    }

    /**
     * @param string $newname
     * @param bool $overwrite
     * @return bool
     * @throws Exception\FileException
     */
    public function move($newname, $overwrite = false)
    {
        return $this->rename($newname, $overwrite);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        return FileSystem::delete($this);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function serialize()
    {
        throw new \RuntimeException("Unsupported operation");
    }

    /**
     * @param string $serialized
     * @throws \RuntimeException
     */
    public function unserialize($serialized)
    {
        throw new \RuntimeException("Unsupported operation");
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return substr(strrchr($this->path, '/'), 1);
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return substr(strrchr($this->path, '.'), 1);
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return FileSystem::fileSize($this);
    }

    /**
     * @return int
     */
    public function getOwner()
    {
        return FileSystem::fileOwner($this);
    }

    /**
     * @return int
     */
    public function getGroup()
    {
        return FileSystem::fileGroup($this);
    }

    /**
     * @return int
     */
    public function lastModified()
    {
        return FileSystem::fileLastModified($this);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return file_get_contents($this->path);
    }
}