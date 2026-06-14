<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('documents', function (Blueprint $table) {
        $table->dropForeign(['origin_user_id']);
        $table->dropForeign(['current_user_id']);

        $table->foreign('origin_user_id')
            ->references('id')
            ->on('users')
            ->nullOnDelete();

        $table->foreign('current_user_id')
            ->references('id')
            ->on('users')
            ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('documents', function (Blueprint $table) {
        $table->dropForeign(['origin_user_id']);
        $table->dropForeign(['current_user_id']);

        $table->foreign('origin_user_id')
            ->references('id')
            ->on('users_orig')
            ->nullOnDelete();

        $table->foreign('current_user_id')
            ->references('id')
            ->on('users_orig')
            ->nullOnDelete();
    });
}
};
