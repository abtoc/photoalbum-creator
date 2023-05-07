<div class="h-100 d-flex flex-column">
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
                        <a href="{{ route('photos.download', ['photo' => $photo->id]) }}" class="link-dark text-decoration-none"><i class="bi bi-download"></i></a>
                        <a href="#" class="link-dark text-decoration none" wire:click="destroy({{ $photo->id }})"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
