<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

    // we want to make sure that even in the db if true or false is stored as 1 or 0
    // we want to return a boolean
    protected $casts = [
        'completed' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($task) {

            $task->project->recordActivity('created_task');

        });

        static::updated(function ($task) {

            if( ! $task->completed ) return;

            $task->project->recordActivity('completed_task');

        });
    }

    public function completed() {
        $this->update(['completed' => true]);
    }

}
