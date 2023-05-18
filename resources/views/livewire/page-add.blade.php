<div wire:ignore.self class="modal" id="album-photos-add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Photo') }}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between py-2">
                    <div>
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <select class="form-select form-select-sm" wire:model="uploaded_at">
                                    <option value="">({{ __('Uploaded') }})</option>
                                    @foreach($uploaded as $up)
                                        <option value="{{ $up->uploaded_at->toDateString() }}">{{ $up->uploaded_at->toDateString() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <input type="checkbox" class="form-check-input" id="favorite" wire:model="favorite">
                                <label class="form-check-label" for="favorite">{{ __('Favorite') }}</label>
                            </div>
                            <div class="col-auto">
                                <input type="checkbox" class="form-check-input" id="not_albumed" wire:model="not_albumed">
                                <label class="form-check-label" for="not_albumed">{{ __('Not Albumed') }}</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <table id="photos-info" class="table table-sm table-bordered fixed mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-dark">{{ __('Selected') }}</th>
                                    <td class="column-value text-end">{{ $count }}</td>
                                    <th class="table-dark">{{ __('Favorites' )}}</th>
                                    <td class="column-value text-end">{{ $favorites }}</td>
                                    <th class="table-dark">{{ __('Pages') }}</th>
                                    <td class="column-value text-end">{{ $album->pages()->count() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
