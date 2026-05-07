<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    protected $fillable = [
        'email', 'password_hash', 'full_name',
        'university', 'study_program', 'semester',
        'role', 'is_verified', 'is_active',
    ];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active'   => 'boolean',
        'deleted_at'  => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }
}