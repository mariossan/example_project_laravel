<?php

namespace App\Http\Traits;

use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{

    /**
     * @method
     * Metodo para guardar imagen
     * @param UploadedFile $uploadedFile
     * @param string $folder
     * @return string
    */
    public function upload(UploadedFile $uploadedFile, string $folder)
    {
        $image = $uploadedFile->store("{$folder}",'public');
        return Storage::url( $image );
    }

    /**
     * @method
     * Metodo para eliminar imagen anterior en disco
     * @param Profile $profile
    */

    public function destroyLast(Profile $profile, string $path)
    {
        if( $profile->image ){
            $file = new Filesystem();
            $file->cleanDirectory($path);
        }
    }
}
