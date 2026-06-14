<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAction extends Model
{
    protected $fillable = [
        'document_id',
        'document_route_id',
        'acted_by',
        'action_taken',
        'remarks',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function route()
    {
        return $this->belongsTo(DocumentRoute::class, 'document_route_id');
    }
}