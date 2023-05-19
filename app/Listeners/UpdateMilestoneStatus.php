<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMilestoneStatus
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $milestone = $event->task->milestone;
        $allTasksCompleted = $milestone->tasks()->where('status', false)->doesntExist();
        if ($allTasksCompleted) {
            $milestone->update(['status' => 1]);
        }
    }
}
