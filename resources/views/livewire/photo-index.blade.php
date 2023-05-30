<div wire:key="photo-index" class="h-100 d-flex flex-column pt-2">
    @livewire('category-select')
    <div class="d-flex justify-content-between">
        <div>
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select class="form-select form-select-sm" wire:model="category">
                        <option value="">({{ __('Category') }})</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
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
                <div class="col-auto">
                    <input type="checkbox" class="form-check-input" id="trashed" wire:model="trashed">
                    <label class="form-check-label" for="trashed">{{ __('Trashed') }}</label>
                </div>
                @if($trashed)
                    <div class="col-auto">
                        <div class="alert alert-warning my-0 py-0">
                            {{ sprintf(__('Items in the trash will be removed after %d days.'), (int)config('app.expire_days')) }}
                        </div>
                    </div>
                @endif 
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <ul id="images">
        @foreach($photos as $photo)
            <li>
                <img src="{{ route('photos.view', ['photo' => $photo, 'size' => '_m']) }}" alt="{{ $photo->name }}" width="240" height="348" loading="lazy">
                <div class="detail">
                    <div>
                        @if(is_null($photo->deleted_at))
                            <a href="#" class="link-dark text-decoration-none" wire:key="photo-like-{{ $photo->id }}" wire:click="like({{ $photo->id }})">@if($photo->favorite)<i class="bi bi-star-fill"></i>@else<i class="bi bi-star"></i>@endif</a>
                        @else
                            @if($photo->favorite)<i class="bi bi-star-fill"></i>@else<i class="bi bi-star"></i>@endif
                        @endif
                        {{$photo->uploaded_at->toDateString() }}:{{ $photo->name }}
                    </div>
                    <div>
                        @if(is_null($photo->deleted_at))
                            <a href="{{ route('photos.download', ['photo' => $photo->id]) }}" class="link-dark text-decoration-none"><i class="bi bi-download"></i></a>
                            <a href="#" class="link-dark text-decoration-none" onclick="selectCategory({{ $photo->id }}); return false;"><i class="bi bi-folder"></i></a>
                            @if($photo->album_count > 0)
                                <a href="" class="link-dark text-decoration-none" onclick="showToast(this, 'toast-{{ $photo->id }}'); return false"><i class="bi bi-book"></i></a>
                                <div class="toast-msg" id="toast-{{ $photo->id }}">
                                    <ul class="list-group">
                                        @foreach($photo->pages as $page)
                                            <li class="list-group-item">
                                                @if(is_null($page->album()->withTrashed()->first()->deleted_at))
                                                    <a href="{{ route('pages.index', ['album' => $page->album]) }}">{{ $page->album->title }}</a>
                                                @else
                                                    {{ $page->album()->withTrashed()->first()->title }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="#" class="link-dark text-decoration-none" wire:click="destroy({{ $photo->id }})" wire:key="photo-destroy-{{ $photo->id }}"><i class="bi bi-trash"></i></a>
                            @endif
                        @else
                            <a href="#" class="link-dark text-decoration-none" wire:click="restore({{ $photo->id }})" wire:key="photo-restore-{{ $photo->id }}"><i class="bi bi-reply"></i></a>
                            <a href="#" class="link-dark text-decoration-none" wire:click="forceDestroy({{ $photo->id }})" wire:key="photo-forceDestroy-{{ $photo->id }}"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
