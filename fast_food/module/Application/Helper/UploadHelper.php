<?php

namespace Application\Helper;

use Eventviva\ImageResize;
use Szy\File\Transfer\AbstractUpload;
use Szy\File\Transfer\UploadedFile;
use Szy\Util\DateTime;

class UploadHelper extends AbstractUpload
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $lista = array();

    /**
     * @var int
     */
    private $count = 0;

    public function __construct($input, $url)
    {
        parent::__construct($input);
        $this->url = $url;
    }

    /**
     * Process the uploaded files
     * @param UploadedFile $file
     * @return void
     */
    protected function process($file)
    {
        $imageResize = new ImageResize($file->getAbsolutePath());
        $imageResize->crop(500, 300);

        $date = new DateTime();
        $imagem = new \StdClass();
        $imagem->codigo = null;
        $imagem->caminho = $this->url . $date->format('Ymdhis') . "-{$this->count}.png";
        $imageResize->save(PUBLIC_PATH . $imagem->caminho, IMAGETYPE_PNG);

        $this->lista[] = $imagem;
        $this->count++;
    }

    public function getLista()
    {
        return $this->lista;
    }
}