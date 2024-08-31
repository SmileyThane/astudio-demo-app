<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'departments_id',
        'start_date',
        'end_date',
        'project_statuses_id',
    ];

    protected $hidden = ['project_statuses_id', 'departments_id', 'created_at', 'updated_at', 'pivot'];

    protected $with = ['department', 'status'];

    final public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }

    final public function status(): BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'project_statuses_id');
    }

    final public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_projects', 'project_id', 'user_id');
    }

    final public function timesheets(): BelongsToMany
    {
        return $this->belongsToMany(Timesheet::class, 'user_projects', 'project_id', 'id', 'id', 'user_projects_id');
    }
}
