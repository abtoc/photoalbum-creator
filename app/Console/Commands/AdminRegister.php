<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:register {name} {email}';

    /**
     * The console command description.
     *


     * @var string
     */
    protected $description = 'Register an administrator user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        $password = $this->secret('Password');
        $confirmed = $this->secret('Confirmed password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmed,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        if($validator->fails()){
            $this->info('Admin User not created. See error messages below.');
            foreach($validator->errors()->all() as $error){
                $this->error($error);
            }
            return 1;
        }

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin Account created.');

        return Command::SUCCESS;
    }
}
