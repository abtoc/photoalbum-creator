<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $overview = (object)[
            'photo_count' => Auth::user()->photos()->count(),
            'album_count' => Auth::user()->albums()->count(),
            'capacity' => Auth::user()->getCapacity(),
            'used_capacity' => Auth::user()->getUsedCapacity(),
        ];
        return view('home', [
            'overview' => $overview,
        ]);
    }
}
