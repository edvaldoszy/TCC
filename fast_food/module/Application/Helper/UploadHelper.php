<?php

namespace Application\Helper;

use Szy\File\Transfer\AbstractUpload;
use Szy\File\Transfer\UploadedFile;

class UploadHelper extends AbstractUpload
{
    /**
     * Process the uploaded files
     * @param UploadedFile $file
     * @return void
     */
    protected function process($file)
    {
        echo $file->getAbsolutePath() . '<br />';
    }
}