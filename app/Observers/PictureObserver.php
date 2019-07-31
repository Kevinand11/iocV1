<?php

namespace App\Observers;

use App\Picture;

class PictureObserver
{
    public function created(Picture $picture): void
    {
        //
    }

    public function updating(Picture $picture): void
    {
        if($picture->isDirty('filename')){
            $filename = $picture->getOriginal('filename');

            if(file_exists(public_path($filename))){
                @unlink(public_path($filename));
            }
        }
    }

    public function updated(Picture $picture): void
    {
        //
    }

    public function deleting(Picture $picture): void
    {
        $filename = $picture->filename;
        
        if(file_exists(public_path($filename))){
            @unlink(public_path($filename));
        }
    }

    public function restored(Picture $picture): void
    {
        //
    }
    
    public function forceDeleted(Picture $picture): void
    {
        //
    }
}
