@extends('layouts.app')

@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subscription') }}</div>
                <div class="card-body">
                    @if(!$status->subscribed)
                        <form id="payment-form" action="{{ route('payments.store')}}" method="POST">
                            <div class="row mb-3">
                                @csrf
                                <input type="hidden" name="stripePaymentMethod" id="method">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Card holder') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="name" placeholder="{{ __('Enter in single-byte alphabetical characters') }}..." required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="card-element" class="col-md-3 col-form-label text-md-end">{{ __('Card infomation')}}</label>
                                    <div class="col-md-8">
                                        <div id="card-element" class="form-control"></div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="plan-month" class="col-md-3 col-form-label text-md-end">{{ __('Plan') }}</label>
                                    <div class="col-md-8">
                                        <div class="btn-group" role="group">
                                            <input name="plan" type="radio" class="btn-check" id="plan-month" autocomplete="off" value="{{ config('payment.plans.month') }}" checked>
                                            <label for="plan-month" class="btn btn-outline-primary">{{ __('Monthly plan (580 yen/Month)') }}</label>
                                            <input name="plan" type="radio" class="btn-check" id="plan-year" autocomplete="off" value="{{ config('payment.plans.year') }}">
                                            <label for="plan-year" class="btn btn-outline-primary">{{ __('Annual plan (5,800 yen/Year)') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-3">
                                        <button id="card-button" class="btn btn-primary" data-secret="{{ $status->intent->client_secret }}">
                                            {{ __('Payment') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        @if($status->status === App\Enums\Payment\Status::CANCELLED)
                            <div class="row mb-3">
                                <label for="status" class="col-md-3 col-form-label text-md-end">{{ __('Status') }}</label>
                                <div class="col-md-8">
                                    <span class="align-middle">
                                        <strong>{{ __('Already cancelled.') }}</strong>({{ __('End') }}:{{ $status->details->end_date }})
                                    </span>
                                    <a href="{{ route('payments.resume') }}" class="btn btn-outline-primary btn-sm" onclick="event.preventDefault(); document.getElementById('payment-resume').submit()">
                                        {{ __('Resume') }}
                                    </a>
                                    <form action="{{ route('payments.resume') }}" id="payment-resume" class="d-none" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <label for="status" class="col-md-2 col-form-label text-md-end">{{ __('Status') }}</label>
                                <div class="col-md-8">
                                    <span class="align-middle">
                                        <strong>{{ __('Currently charging.') }}</strong>
                                    </span>
                                    <a href="{{ route('payments.cancel') }}" class="btn btn-outline-dark btn-sm" onclick="event.preventDefault(); document.getElementById('payment-cancel').submit()">
                                        {{ __('Cancel') }}
                                    </a>
                                    <form action="{{ route('payments.cancel') }}" id="payment-cancel" class="d-none" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="plan" class="col-md-2 col-form-label text-md-end">{{ __('Plan') }}</label>
                                <div class="col-md-8">
                                    <span class="align-middle">
                                        @if($status->details->plan === config('payment.plans.month'))
                                            <strong>{{ __('Monthly plan (580 yen/Month)') }}</strong>
                                            <a href="" class="btn btn-outline-primary btn-sm" onclick="event.preventDefault(); document.getElementById('payment-change').submit()">
                                                {{ __('Switch to an annual plan') }}
                                            </a>
                                            <form action="{{ route('payments.change') }}" id="payment-change" method="POST">
                                                @csrf
                                                <input type="hidden" name="plan" value="{{ config('payment.plans.year') }}">
                                            </form>
                                        @else
                                            <strong>{{__('Annual plan (5,800 yen/Year)') }}</strong>
                                            <a href="" class="btn btn-outline-primary btn-sm" onclick="event.preventDefault(); document.getElementById('payment-change').submit()">
                                                {{ __('Switch to a monthly plan') }}
                                            </a>
                                            <form action="{{ route('payments.change') }}" id="payment-change" method="POST">
                                                @csrf
                                                <input type="hidden" name="plan" value="{{ config('payment.plans.month') }}">
                                            </form>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div id="card-infomation" class="row mb-3">
                                <label for="info" class="col-md-2 col-form-label text-md-end">{{ __('Card infomation') }}</label>
                                <div class="col-md-8">
                                    <span class="align-middle">
                                        <strong>****-****-****-{{ $status->details->card_last_four }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div id="card-update" class="row mb-0">
                                <label for="update" class="col-md-2 col-form-label text-md-end">{{ __('Card update') }}</label>
                                <div class="col-md-10">
                                    <form id="payment-form" action="{{ route('payments.update')}}" method="POST">
                                        <div class="row mb-3">
                                            @csrf
                                            <input type="hidden" name="stripePaymentMethod" id="method">
                                            <div class="row mb-3">
                                                <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Card holder') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" id="name" placeholder="{{ __('Enter in single-byte alphabetical characters') }}..." required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="card-element" class="col-md-3 col-form-label text-md-end">{{ __('Card infomation')}}</label>
                                                <div class="col-md-9">
                                                    <div id="card-element" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-3">
                                                    <button id="card-button" class="btn btn-primary" data-secret="{{ $status->intent->client_secret }}">
                                                        {{ __('Update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                 </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stripe-script')
    @if($status->status !== App\Enums\Payment\Status::CANCELLED)
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #card-element {
            height: 44px;
            padding: 12px;
        }
    </style>
    <script>
        const stripe = Stripe("{{ config('payment.pk_key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {hidePostalCode: true});
        cardElement.mount('#card-element');

        const name = document.getElementById('name');
        const button = document.getElementById('card-button');
        button.addEventListener('click', (event) => {
            event.preventDefault();
            stripe.confirmCardSetup(
                button.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: name.value },
                    }
                }
            )
            .then((result) => {
                console.log(result);
                if(result.error){
                    //alert(result.error.message);
                    const child = document.createElement('div');
                    child.textContent = result.error.message;
                    child.classList.add("alert", "alert-danger", "my-0", "py-1");
                    child.setAttribute('role', 'alert');
                    let alerts = document.getElementById('alerts');
                    while(alerts.firstChild){
                        alerts.removeChild(alerts.firstChild);
                    }
                    alerts.appendChild(child);
                } else {
                    console.log(result.setupIntent);
                    const method = document.getElementById('method');
                    method.value = result.setupIntent.payment_method;
                    const form = document.getElementById('payment-form');
                    form.submit();
                }
            });
        });
    </script>
    @endif
@endpush
