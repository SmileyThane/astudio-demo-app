<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_projects_id',
        'title',
        'date',
        'spent_hours',
    ];

    protected $hidden = ['pivot', 'created_at', 'updated_at'];
}
