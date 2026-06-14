<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'profile_photo',
        'name',
        'fname',
        'mname',
        'lname',
        'extension',
        'email',
        'password',
        'office_id',
        'mobile_no',
        'emp_no',
        'emp_type',
        'emp_title',
        'region_code',
        'department_code',
        'office_code',
        'status',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User belongs to an office.
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Full name accessor.
     */
    public function getFullNameAttribute()
    {
        return collect([
            $this->fname,
            $this->mname,
            $this->lname,
            $this->extension,
        ])->filter()->implode(' ');
    }
}