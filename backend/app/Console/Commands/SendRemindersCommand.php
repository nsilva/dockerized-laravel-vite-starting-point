<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Notifications\DelayedTodos;
use App\Support\Enums\TodoStatusEnum;
use Illuminate\Console\Command;
use App\Jobs\SendReminders;
use Illuminate\Support\Carbon;

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

        // Since we are setting the parent as in progress when child is in progress,
        // we just need to query for parents
        $pendingTodos = Todo::select(['user_id'])
            ->distinct()
            ->selectRaw('count(id) as pending_tasks')
            ->whereNull('parent_id')
            ->where('status', TodoStatusEnum::IN_PROGRESS->value)
            ->whereDate('in_progress_since', '<', Carbon::now()->subHours(24)->toDateString())
            ->with('user')
            ->groupBy('user_id')
            ->get();

        $pendingTodos->each(function($todo) {
            $todo->user->notify(new DelayedTodos($todo->pending_tasks));
        });
    }
}
