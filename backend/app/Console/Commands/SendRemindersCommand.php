<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendReminders;

class SendRemindersCommand extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminders to users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Sending reminders...');

        dispatch(new SendReminders());

        $this->info('Reminders sent successfully!');
    }
}
