<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('document_actions', function (Blueprint $table) {
            $table->dropForeign(['acted_by']);

            $table->foreign('acted_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('document_actions', function (Blueprint $table) {
            $table->dropForeign(['acted_by']);

            $table->foreign('acted_by')
                ->references('id')
                ->on('users_orig')
                ->nullOnDelete();
        });
    }
};