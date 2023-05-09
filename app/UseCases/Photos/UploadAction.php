<?php

namespace App\UseCases\Photos;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class UploadAction
{
    public function __invoke(Request $request)
    {
        DB::transaction(function() use($request){
            $name = pathinfo($request->file->getClientOriginalName(),PATHINFO_FILENAME);
            $today = Carbon::today();

            $photo = Auth::user()->photos()->withTrashed()
                ->where('name', $name)
                ->where('uploaded_at', $today)
                ->first();
            if($photo == null){
                $photo = Auth::user()->photos()->create([
                    'name' => $name,
                    'uploaded_at' => $today,
                ]);
            } elseif($photo->deleted_at != null) {
                $photo->restore();
            }

            $image = Image::make($request->file);
            $image = $image->crop(1920,3072,64,0);
            $image_m = clone $image;
            $image_s = clone $image;
            $image = $image->resize(1600,2560);
            $image = $image->encode('jpg');
            $image = $image->__toString();
            Storage::disk('s3')->put($photo->getPath(), $image);
            $photo->capacity = Storage::disk('s3')->size($photo->getPath());
            $image_m = $image_m->resize(200, 320);
            $image_m = $image_m->encode('jpg');
            $image_m = $image_m->__toString();
            Storage::disk('s3')->put($photo->getPath('_m'), $image_m);
            $image_s = $image_s->resize(120, 192);
            $image_s = $image_s->encode('jpg');
            $image_s = $image_s->__toString();
            Storage::disk('s3')->put($photo->getPath('_s'), $image_s);
            $photo->save();
        });
    }
}