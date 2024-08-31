<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'date_of_birth',
        'sex',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
        'created_at',
        'updated_at',
    ];

    final public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_projects', 'user_id', 'project_id');
    }

    final public function timesheets(): BelongsToMany
    {
        return $this->belongsToMany(Timesheet::class, 'user_projects', 'user_id', 'id', 'id', 'user_projects_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    final protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
