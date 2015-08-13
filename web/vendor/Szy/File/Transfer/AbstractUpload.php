<?php

namespace Szy\File\Transfer;

use Countable;
use InvalidArgumentException;

abstract class AbstractUpload implements Countable
{
    /**
     * @var array
     */
    private $input;

    /**
     * @param string $input
     * @throws InvalidArgumentException
     */
    public function __construct($input = "anexo")
    {
        if (!isset($_FILES[$input]))
            throw new InvalidArgumentException("Invalid input name");

        $this->input = $_FILES[$input];
    }

    public function run()
    {
        for ($n = 0; $n < $this->count(); $n++) {
            $file = new UploadedFile($this->input["tmp_name"][$n], $this->input["name"][$n], $this->input["type"][$n], $this->input["error"][$n]);
            $this->process($file);
        }
    }

    /**
     * Process the uploaded files
     * @param UploadedFile $file
     * @return void
     */
    abstract public function process($file);

    /**
     * @return int
     */
    public function count()
    {
        return count($this->input["name"]);
    }
}