<?php

namespace App\UseCases\Options;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UpdateAction
{
    public function __invoke(Request $request)
    {
        DB::transaction(function() use($request){
            foreach($request->only(array_keys(config('options'))) as $name => $value){
                Option::put($name, $value);
            }
        });
    }
}