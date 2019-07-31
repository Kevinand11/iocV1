<?php

namespace App\Listeners;

use App\Events\NewImageUploadedEvent;
use App\Picture;
use Intervention\Image\ImageManagerStatic as Image;

class CreateImageForUserAndStoreListener
{
    public function handle(NewImageUploadedEvent $event): void
    {
        $image = $event->params['image'];
        $object = $event->params['object'];
        $path = $event->params['path'];
        $type = $event->params['type'];
		$name = time().'.'.explode('/',explode(':',substr($image,0,
				strpos($image,';')))[1])[1];
		Image::make($image)->save(public_path($path).$name);
		if($object->picture){
			$object->picture->update(['filename' => $path.$name]);
		}else{
			Picture::create([
				'imageable_id' => $object->id,
			]);
		}
    }
}
