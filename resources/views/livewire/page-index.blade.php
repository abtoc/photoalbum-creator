<div class="h-100 d-flex flex-column">
    @livewire('page-add', ['album' => $album])
    <hr>
    <ul id="images">
        <li>
            <img src="{{ route('albums.cover', ['album' => $album]) }}" alt="cover" style="max-width:240px;" class="mt-3">
            <div class="detail">
                <div>
                    {{ __('Cover') }}
                </div>
            </div>
    </li>
        @foreach($photos as $photo)
            <li>
                <img src="{{ route('photos.view', ['photo' => $photo->id, 'size' => '_m']) }}" alt="{{ $photo->name }}">
                <div class="detail">
                    <div>
                        Page: {{ $photo->page }},{{ $photo->name }}
                    </div>
                    <div>
                        <a href="#" class="link-dark text-decoration none" wire:click="destroy({{ $photo->id }})"><i class="bi bi-x-lg"></i></a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
