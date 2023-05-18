<div wire:poll.10s class='justify-content-center'>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
    </div>
    <div class="w-100 text-center">
        @capacity($used)/@capacity($total)
    </div>
</div>
