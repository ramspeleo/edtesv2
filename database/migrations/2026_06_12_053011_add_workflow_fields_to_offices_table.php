<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->unsignedTinyInteger('approval_level')
                ->default(1)
                ->after('office_type');

            $table->enum('office_group', [
                'central',
                'regional'
            ])->nullable()->after('approval_level');
        });
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn([
                'approval_level',
                'office_group'
            ]);
        });
    }
};