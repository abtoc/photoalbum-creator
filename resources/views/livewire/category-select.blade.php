<div wire:ignore.self class="modal" id="category-select" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Category Select') }}</h5>              
                <button class="btn-close" wire:click="close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="{{ __('Please enter the category you wish to add...') }}">
                    <button class="btn btn-outline-secondary" wire:click="add">{{ __('Add' )}}</button>
                </div>
                <div class="pb-2">
                    @error('name')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <ul class="list-group">
                    @foreach($categories as $category)
                        <li class="list-group-item">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="category-{{ $category->id }}" value="{{ $category->id }}" wire:model="checks.{{ $category->id }}">
                                <label for="category-{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" wire:click="close">{{ __('Close') }}</button>
                <button class="btn btn-primary btn-sm" wire:click="submit">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
