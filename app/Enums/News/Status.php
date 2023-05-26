<?php

namespace App\Enums\News;

enum Status : string
{
    case DRAFT = 'draft';
    case PUBLISH = 'publish';

    public function string(): string
    {
        return match($this){
            Status::DRAFT => __('Draft'),
            Status::PUBLISH => __('Publish'),
        };
    }
}