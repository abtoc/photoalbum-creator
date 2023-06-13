<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Change administrator's password.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');

        $password = $this->secret('Password');
        $confirmed = $this->secret('Confirmed password');

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmed,
        ], [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:admins,email'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        if($validator->fails()){
            $this->info('Admin User not password changed. See error messages below.');
            foreach($validator->errors()->all() as $error){
                $this->error($error);
            }
            return 1;
        }


        Admin::where('email', $email)
            ->update([
                'password' => Hash::make($password),
            ]);

            $this->info('Admin Account password changed.');

            return Command::SUCCESS;
        }
}
