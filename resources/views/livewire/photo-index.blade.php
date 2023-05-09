<div class="h-100 d-flex flex-column pt-2">
    <div class="d-flex justify-content-between">
        <div>
            <div class="row g-1 align-items-center">
                <div class="col-auto">
                    <input type="checkbox" class="form-check-input" id="favorite" wire:model="favorite">
                    <label class="form-check-label" for="favorite">{{ __('Favorite') }}</label>
                </div>
                <div class="col-auto">
                    <input type="checkbox" class="form-check-input" id="not_albumed" wire:model="not_albumed">
                    <label class="form-check-label" for="not_albumed">{{ __('Not Albumed') }}</label>
                </div>
                <div class="col-auto">
                    <select class="form-select form-select-sm" wire:model="uploaded_at">
                        <option value="">({{ __('None') }})</option>
                        @foreach($uploaded as $up)
                            <option value="{{ $up->uploaded_at->toDateString() }}">{{ $up->uploaded_at->toDateString() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div>
            {{ __('Selected') }}:{{ $count }},{{ __('Favorites' )}}:{{ $favorites }}

        </div>
    </div>
    <hr>
    <ul id="images">
        @foreach($photos as $photo)
            <li>
                <img src="{{ route('photos.view', ['photo' => $photo->id, 'size' => '_m']) }}" alt="{{ $photo->name }}" width="240" height="348" loading="lazy">
                <div class="detail">
                    <div>
                        <a href="#" class="link-dark text-decoration-none" wire:click="like({{ $photo->id }})">@if($photo->favorite)<i class="bi bi-star-fill"></i>@else<i class="bi bi-star"></i>@endif</a>
                        {{$photo->uploaded_at->toDateString() }}:{{ $photo->name }}
                    </div>
                    <div>
                        @if($photo->album_count > 0)
                            <i class="bi bi-book"></i>
                        @endif
                        <a href="{{ route('photos.download', ['photo' => $photo->id]) }}" class="link-dark text-decoration-none"><i class="bi bi-download"></i></a>
                        <a href="#" class="link-dark text-decoration none" wire:click="destroy({{ $photo->id }})"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
