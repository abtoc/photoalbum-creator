<div class="container-fluid p-2">
    @foreach(Alert::getMessages() as $key => $messages)
        @foreach($messages as $message)
            <div class="alert alert-{{ $key }} my-0 py-1" role="alert">{{ $message }}</div>
        @endforeach
    @endforeach
</div>