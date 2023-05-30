<?php

namespace App\Enums\Payment;

enum Status : int
{
    case UNSUBSCRIBED = 0;
    case CANCELLED = 1;
    case SUBSCRIBED = 2;

    public function string(): string
    {
        return match($this){
            Status::UNSUBSCRIBED => __('Unsubscribed'),
            Status::CANCELLED => __('Cancelled'),
            Status::SUBSCRIBED => __('Subscribed'),
        };
    }
}
