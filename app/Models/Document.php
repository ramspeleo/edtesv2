<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'tracking_number',
        'document_number',
        'reference_number',
        'document_type_id',
        'document_date',
        'subject',
        'description',
        'origin_office_id',
        'origin_user_id',
        'current_office_id',
        'current_user_id',
        'priority',
        'confidentiality',
        'status',
        'main_document_path',
    ];

    protected $casts = [
        'document_date' => 'date',
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function originOffice()
    {
        return $this->belongsTo(Office::class, 'origin_office_id');
    }

    public function currentOffice()
    {
        return $this->belongsTo(Office::class, 'current_office_id');
    }

    public function originUser()
    {
        return $this->belongsTo(User::class, 'origin_user_id');
    }

    public function currentUser()
    {
        return $this->belongsTo(User::class, 'current_user_id');
    }

    public function routes()
    {
        return $this->hasMany(DocumentRoute::class);
    }

    public function actions()
    {
        return $this->hasMany(DocumentAction::class);
    }
    
}