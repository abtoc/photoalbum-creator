<div class="h-100 d-flex flex-column">
    @livewire('album-photos-add', ['album' => $album])
    <hr>
    <ul id="images">
        @foreach($photos as $photo)
            <li>
                <img src="{{ route('photos.view', ['photo' => $photo->id, 'size' => '_m']) }}" alt="{{ $photo->name }}">
                <div class="detail">
                    <div>
                        Page: {{ $photo->page }}
                    </div>
                    <div>
                        <a href="#" class="link-dark text-decoration none" wire:click="destroy({{ $photo->id }})"><i class="bi bi-x-lg"></i></a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
