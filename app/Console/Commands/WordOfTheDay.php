<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// custom imports
use Illuminate\Support\Facades\Mail;
use App\User;

class WordOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';

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
     * @return mixed
     */
    public function handle()
    {
        $words = [
            'aberration' => 'a state or condition markedly different from the norm',
            'convivial' => 'occupied with or fond of the pleasures of good company',
            'diaphanous' => 'so thin as to transmit light',
            'elegy' => 'a mournful poem; a lament for the dead',
            'ostensible' => 'appearing as such but not necessarily so'
        ];
 
        // Finding a random word
        $key = array_rand($words);
        $value = $words[$key];
 
        $user = User::find(1);
        
        Mail::raw("{$key} -> {$value}", function ($mail) use ($user) {
            $mail->from('usmansabir98@hotmail.com');
            // $mail->from('postmaster@sandboxb9de5c7895cb42fbbf7d4ad3c935ca0f.mailgun.org');
            $mail->to('usmansabir98@gmail.com')
                ->subject('Word of the Day');
        });
        
 
        $this->info('Word of the Day sent to All Users');
    }
}
