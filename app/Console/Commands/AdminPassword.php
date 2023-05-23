<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

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

        system('stty -echo');
        fwrite(STDERR, 'Passwrod: ');
        $password = rtrim(fgets(STDIN));
        fwrite(STDERR, PHP_EOL.'Confirmed password: ');
        $confirmed = rtrim(fgets(STDIN));
        fwrite(STDERR, PHP_EOL);
        system('stty echo');

        if($password != $confirmed){
            fwrite(STDERR, 'Password does not match.'.PHP_EOL);
            return 1;
        }

        $query = Admin::query()
                    ->where('email', $email);
        if($query->exists()){
            $admin = $query->first();
            $admin->update([
                'password' => Hash::make($password),
            ]);
            return Command::SUCCESS;
        }
        echo "{$email} is not found.";
        return 1;
    }
}
