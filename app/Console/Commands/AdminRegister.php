<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

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

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return Command::SUCCESS;
    }
}
