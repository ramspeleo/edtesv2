<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRoute extends Model
{
    protected $fillable = [
        'document_id',
        'from_office_id',
        'from_user_id',
        'to_office_id',
        'to_user_id',
        'action_required',
        'delivery_type',
        'deadline',
        'remarks',
        'routed_by',
        'routed_at',
        'received_by',
        'received_at',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'routed_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function fromOffice()
    {
        return $this->belongsTo(Office::class, 'from_office_id');
    }

    public function toOffice()
    {
        return $this->belongsTo(Office::class, 'to_office_id');
    }

    public function routedBy()
    {
        return $this->belongsTo(User::class, 'routed_by');
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

   
}