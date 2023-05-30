<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Category') }}</div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model="name" placeholder="{{ __('Please enter the category you wish to add...') }}">
                        @if(is_null($category_id))
                            <button class="btn btn-outline-secondary" wire:click="add">{{ __('Add' )}}</button>
                        @else
                            <button class="btn btn-outline-secondary" wire:click="update">{{ __('Update' )}}</button>
                        @endif
                        <button class="btn btn-outline-secondary" wire:click="cancel">{{ __('Cancel') }}</button>
                    </div>
                    <div class="pb-2">
                        @error('name')
                            <span class="invalid-feedback d-inline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Category Name') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }} ({{ $category->photos()->count() }})</td>
                                    <td class="text-end">
                                        <a href="#" class="link-dark text-decoretion-none" wire:click="edit({{ $category->id }})"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="link-dark text-decoretion-none" wire:click="destroy({{ $category->id }})" data-confirm="{{ sprintf(__('Can I delete %s?'), $category->name) }}" onclick="wireClickConfirm(this, event)"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
