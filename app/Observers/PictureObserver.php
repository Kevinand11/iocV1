<?php

namespace App\Observers;

use App\Picture;

class PictureObserver
{
    public function created(Picture $picture)
    {
        //
    }

    public function updating(Picture $picture)
    {
        if($picture->isDirty('filename')){
            $filename = $picture->getOriginal('filename');

            if(file_exists(public_path($filename))){
                @unlink(public_path($filename));
            }
        }
    }

    public function updated(Picture $picture)
    {
        //
    }

    public function deleting(Picture $picture)
    {
        $filename = $picture->filename;
        
        if(file_exists(public_path($filename))){
            @unlink(public_path($filename));
        }
    }

    public function restored(Picture $picture)
    {
        //
    }
    
    public function forceDeleted(Picture $picture)
    {
        //
    }
}
