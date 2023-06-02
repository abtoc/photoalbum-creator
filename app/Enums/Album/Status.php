<?php

namespace App\Enums\Album;

enum Status : int
{
    case NONE = 0;
    case PUBLISHING = 1;
    case PUBLISHED = 2;
    case TRASHED = 9;
    case ERROR = 9999;

    public function string(): string
    {
        return match($this){
            Status::NONE => __('Unpublished'),
            Status::PUBLISHING => __('Publishing'),
            Status::PUBLISHED => __('Published'),
            Status::TRASHED => __('Trashed'),
            Status::ERROR => __('ERROR'),
        };
    }
}