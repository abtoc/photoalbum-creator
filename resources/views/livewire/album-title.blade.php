<div wire:poll>
    @if(\Storage::disk('s3')->exists($album->getPath()))
        <a href="{{ route('albums.download', ['album' => $album]) }}">{{ $album->title }}</a>
    @else
        {{ $album->title }}                            
    @endif
</div>
