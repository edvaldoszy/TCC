<?php

namespace Szy\File\Transfer;

use Szy\File\Exception\FileException;
use Szy\File\File;
use RuntimeException;

class UploadedFile extends File
{
    /**
     * @var string
     */
    private $temp;

    /**
     * File mime type
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $error;

    public function __construct($path, $name, $type, $error)
    {
        $this->getInfo($path);
        $this->name = $name;
        $this->extension = substr(strrchr($name, '.'), 1);
        $this->type = $type;
        $this->error = $error;
    }

    /**
     * Get file info
     * @param $path
     */
    protected function getInfo($path)
    {
        $this->path = $path;
        $this->size = filesize($path);
    }

    /**
     * @param string $newname
     * @param bool|false $overwrite
     * @return File|void
     */
    /*
    public function copy($newname, $overwrite = false)
    {
        throw new RuntimeException("Unsupported operation");
    }
    */

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }
}