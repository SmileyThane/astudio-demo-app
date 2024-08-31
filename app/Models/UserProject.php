<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProject extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id'];

    final public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class, 'user_projects_id', 'id');
    }
}
