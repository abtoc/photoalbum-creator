<div wire:poll.60s class="d-inline">
    @if($album->status === App\Enums\Album\Status::PUBLISHED)
        <a href="{{ route('albums.download', ['album' => $album]) }}" class="link-dark text-decoration-none"><i class="bi bi-download"></i></a>
    @endif
</div>
