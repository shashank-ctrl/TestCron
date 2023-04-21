<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\BirthDayWish;
use App\Models\User;

class AutoBirthDayWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:birthdaywish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereMonth('birthdate', date('m'))
                    ->whereDay('birthdate', date('d'))
                    ->get();
  
        if ($users->count() > 0) {
            foreach ($users as $user) {
                Mail::to($user)->send(new BirthDayWish($user));
            }
        }
  
        return 0;
    }
}
