<?php

namespace App\Http\Controllers;

use App\Enums\Payment\Status;
use App\Events\Subscribed;
use App\Events\Unsubscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscribed = false;
        $details = (object)[];
        $status = Status::UNSUBSCRIBED;

        if($user->subscribed('default')){
            $subscribed = true;
            if($user->subscription('default')->canceled()){
                $status = Status::CANCELLED;
            } else {
                $status = Status::SUBSCRIBED;
            }

            $subscription = $user->subscriptions->first(function($value){
                return $value->name === 'default';
            })->only('ends_at', 'stripe_price');

            $details = (object)[
                'end_date' => $subscription['ends_at'] ? $subscription['ends_at']->toDateString() : null,
                'plan' => $subscription['stripe_price'],
                'card_last_four' => $user->pm_last_four,
            ];
        }

        $status = (object)[
            'status' => $status,
            'intent' => $user->createSetupIntent(),
            'subscribed' => $subscribed,
            'details' => $details,
        ];

        return view('payments.index', ['status' => $status]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $customer = $user->createOrGetStripeCustomer();

        if(!$user->subscribed('default')){
            $method = $request->input('stripePaymentMethod');
            $plan = $request->input('plan');
            $user->newSubscription('default', $plan)->create($method);
        }

        event(new Subscribed($user));

        Alert::info(__('Subscription signed up.'));
        Alert::flash();

        return to_route('payments.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $customer = $user->createOrGetStripeCustomer();

        $method = $request->input('stripePaymentMethod');
        $user->updateDefaultPaymentMethod($method);

        Alert::info(__('Updated credit cards.'));
        Alert::flash();

        return to_route('payments.index');
    }

    public function change(Request $request)
    {
        $user = Auth::user();
        $plan = $request->input('plan');

        $user->subscription('default')->swap($plan);
        
        if($plan === config('payment.plans.month')){
            Alert::info(__('Changed to monthly plan.'));
        } else {
            Alert::info(__('Changed to annual plan.'));
        }
        Alert::flash();

        return to_route('payments.index');
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();

        $user->subscription('default')->cancel();

        event(new Unsubscribed($user));

        Alert::info(__('Subscription canceled.'));
        Alert::flash();

        return to_route('payments.index');
    }

    public function resume(Request $request)
    {
        $user = Auth::user();

        $user->subscription('default')->resume();

        event(new Subscribed($user));

        Alert::info(__('Subscriptions have resumed.'));
        Alert::flash();

        return to_route('payments.index');
    }
}
