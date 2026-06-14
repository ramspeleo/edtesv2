<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        DocumentType::truncate();

        $types = [
            'Memorandum',
            'Letter',
            'Office Order',
            'Circular',
            'Endorsement',
            'Report',
            'Contract',
            'Notice',
            'Purchase Request',
            'RFA Document',
            'Regular Case Document',
            'VA Document',
            'Travel Order',
            'Others',
        ];

        foreach ($types as $type) {
            DocumentType::create([
                'name' => $type,
                'description' => null,
                'is_active' => true,
            ]);
        }
    }
}