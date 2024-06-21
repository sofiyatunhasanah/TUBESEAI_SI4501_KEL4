<?php

namespace App\Listeners;

use App\Events\ProjectProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNewProject
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
     * @param  \App\Events\ProjectProcessed  $event
     * @return void
     */
    public function handle(ProjectProcessed $event)
    {
        $project = $event->project;
        $logMessage = "Processing new project: {$project->name}, Budget : {$project->budget}, Responsible User: {$project->responsible_user}, Status: {$project->status}, User ID: {$project->user_id}";
        Log::info("Processing new project: {$project->name}, Budget : {$project->budget}, Responsible User: {$project->responsible_user}, Status: {$project->status}, User ID: {$project->user_id}");
        file_put_contents('php://stderr', $logMessage . PHP_EOL);
        $project->addProject($project->name, $project->budget, $project->responsible_user, $project->status, $project->user_id);
    }
}