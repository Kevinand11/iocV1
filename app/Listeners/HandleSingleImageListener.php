<?php

namespace App\Listeners;

use App\Events\NewSingleImageUploadedEvent;
use Intervention\Image\Facades\Image;

class HandleSingleImageListener
{
    public function handle(NewSingleImageUploadedEvent $event): void
    {
        $image = $event->params['image'];
        $object = $event->params['object'];
        $path = $event->params['path'];
		$name = time().'.'.explode('/',explode(':',substr($image,0,
				strpos($image,';')))[1])[1];
		Image::make($image)->save(public_path($path).$name);
		if($object->picture){
			$object->picture->update(['filename' => $path.$name]);
		}else{
			$object->picture()->create([ 'filename' => $path.$name ]);
		}
    }
}
