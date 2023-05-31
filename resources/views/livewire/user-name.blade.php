<div wire:ignore.self class="modal" id="user-name-change" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('User name change') }}</h5>
                <button class="btn-close" wire:click="close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="{{ __('Enter your name...') }}">
                @error('name')
                    <span class="invalid-feedback d-inline" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" wire:click="close">{{ __('Close') }}</button>
                <button class="btn btn-primary btn-sm" wire:click="submit">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
