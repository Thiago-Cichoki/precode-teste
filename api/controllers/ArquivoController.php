<?php

namespace api\controllers;

use util\Util;

class ArquivoController
{

    public function upload($file)
    {
        $directory = 'uploads' . DIRECTORY_SEPARATOR;
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = date('YmdHis') . '.' . $imageFileType;
        $destination = $directory . $filename;
        

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            throw new Exception('Extensão de arquivo inválida');
        }

        list($width, $height) = getimagesize($file["tmp_name"]);
        if (!$width || !$height) {
            throw new Exception('Arquivo de imagem inválido');
        }

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Upload não foi realizado');
        }

        return Util::getPathApi() . DIRECTORY_SEPARATOR .  $destination;
    }
    
}
