<?php

namespace App\Http\Controllers;

use App\Enums\News\Status;
use App\Models\News;
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
        $news_list = News::query()
                    ->orderBy('updated_at', 'desc')
                    ->where('status', Status::PUBLISH)
                    ->limit(10)
                    ->get();
        $overview = (object)[
            'subcribed' => Auth::user()->subscribed('default'),
            'photo_count' => Auth::user()->photos()->count(),
            'album_count' => Auth::user()->albums()->count(),
            'capacity' => Auth::user()->getCapacity(),
            'used_capacity' => Auth::user()->getUsedCapacity(),
        ];
        $activites = Auth::user()->activites()
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
        return view('home', [
            'news_list' => $news_list,
            'overview' => $overview,
            'activites' => $activites,
        ]);
    }
}
