<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.home', [
            'overview' => $overview,
        ]);
    }
}
