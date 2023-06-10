<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $overview = (object)[
            'users_count' => User::query()->count(),
            'subscriptions_count' => Subscription::query()->active()->count(),
        ];
        $activites = Activity::query()
                        ->where('user_id', 0)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
        return view('admin.home', [
            'overview' => $overview,
            'activites' => $activites,
        ]);
    }
}
