<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\UseCases\Options\UpdateAction;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class OptionController extends Controller
{
    public function index()
    {
        $option = (object)[
            'publisher' => Option::get('publisher'),
            'lines_per_page' => Option::get('lines_per_page'),
            'expire' => Option::get('expire'), 
        ];
        return view('options.index', ['option' => $option]);
    }

    public function update(Request $request, UpdateAction $action)
    {
        $request->validate([
            'publisher' => ['nullable', 'string'],
            'lines_per_page' => ['required', 'integer', 'min:0'],
            'expire' => ['required', 'integer', 'min:0'],
        ]);
        $action($request);
        Alert::info(__('Setting updated.'));
        Alert::flash();
        return to_route('options.index');
    }
}
