<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PrunePlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:prune-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune models plan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = User::query();
        foreach($query->cursor() as $user){
            $album = $user->albums()
                ->onlyTrashed()
                ->selectRaw('sum(capacity) as capacity')
                ->where('deleted_at', '<', now()->subDay((int)config('app.expire_day')))
                ->first();
            $photo = $user->photos()
                ->onlyTrashed()
                ->selectRaw('sum(capacity) as capacity')
                ->where('deleted_at', '<', now()->subDay((int)config('app.expire_day')))
                ->first();
            $capacity = $album->capacity + $photo->capacity;
            if($capacity > 0){
                Log::info('Delete data.', ['email' => $user->email, 'capacity' => byte_to_unit($capacity)]);
                Activity::create([
                    'user_id' => $user->id,
                    'details' => sprintf(__('Deleted for %s.'), byte_to_unit($capacity)),
                ]);
            }
        }
        return Command::SUCCESS;
    }
}
