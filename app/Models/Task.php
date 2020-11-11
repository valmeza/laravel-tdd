<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

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
}
