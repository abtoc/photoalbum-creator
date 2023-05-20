<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::query()->cursor() as $user){
            foreach(config('options') as $name => $value){
                if(!$user->options()->where('name', $name)->exists()){
                    $user->options()->create([
                        'name' => $name,
                        'value' => $value,
                    ]);
                }
            }
        }
    }
}
