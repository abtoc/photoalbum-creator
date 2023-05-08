<div wire:ignore.self class="modal" id="album-photos-add" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Photo') }}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="modal-images">
                    @foreach($photos as $photo)
                        <li>
                            <img src="{{ route('photos.view', ['photo' => $photo->id, 'size' => '_m']) }}" alt="{{ $photo->name }}" width="240" height="348" loading="lazy" wire:dblclick="add({{ $photo->id }})">
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
