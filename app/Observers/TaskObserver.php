<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $task->recordActivity('created_task');
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->recordActivity('deleted_task');
    }

}
