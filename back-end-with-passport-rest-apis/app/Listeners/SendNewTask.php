<?php

namespace App\Listeners;

use App\Events\TaskProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNewTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TaskProcessed  $event
     * @return void
     */
    public function handle(TaskProcessed $event)
    {
        $task = $event->task;
        $logMessage = "Processing new task: {$task->name}, Due Date: {$task->due_date}, Responsible User: {$task->responsible_user}, Status: {$task->status}, User ID: {$task->user_id}";
        Log::info("Processing new task: {$task->name}, Due Date: {$task->due_date}, Responsible User: {$task->responsible_user}, Status: {$task->status}, User ID: {$task->user_id}");
        // Directly write to stderr for debugging
        file_put_contents('php://stderr', $logMessage . PHP_EOL);
        $task->addTask($task->name, $task->due_date, $task->responsible_user, $task->status, $task->user_id);
    }
}