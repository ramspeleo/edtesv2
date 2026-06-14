<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'office_code',
        'office_name',
        'office_type',
        'parent_office_id',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_office_id');
    }

    public function children()
    {
        return $this->hasMany(Office::class, 'parent_office_id');
    }
}