<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
* Trait destinado para manejo de archivos en todo el sistema
*/
trait FileTrait
{
    /**
     * @method metodo para convertir un numero EUROPEO a ISO
    * @return
    */
    public function uploadFileToServer( $path,UploadedFile $file )
    {

        /* si el directorio no existe se crea */
        if( !Storage::exists($path) ) {
            Storage::makeDirectory($path);
        }

        /* se almacena la inforamcion del file */
        $newFileName    = date("YmdHis");
        $response       = $file->move( storage_path("app/$path"), "{$newFileName}.{$file->clientExtension()}" );
        return "$newFileName.{$file->clientExtension()}";

    }

}
