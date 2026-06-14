<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('document_routes', function (Blueprint $table) {
            $table->dropForeign(['from_user_id']);

            if (Schema::hasColumn('document_routes', 'routed_by')) {
                $table->dropForeign(['routed_by']);
            }

            if (Schema::hasColumn('document_routes', 'received_by')) {
                $table->dropForeign(['received_by']);
            }

            $table->foreign('from_user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('routed_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            if (Schema::hasColumn('document_routes', 'received_by')) {
                $table->foreign('received_by')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('document_routes', function (Blueprint $table) {
            $table->dropForeign(['from_user_id']);
            $table->dropForeign(['routed_by']);

            if (Schema::hasColumn('document_routes', 'received_by')) {
                $table->dropForeign(['received_by']);
            }

            $table->foreign('from_user_id')
                ->references('id')
                ->on('users_orig')
                ->nullOnDelete();

            $table->foreign('routed_by')
                ->references('id')
                ->on('users_orig')
                ->nullOnDelete();

            if (Schema::hasColumn('document_routes', 'received_by')) {
                $table->foreign('received_by')
                    ->references('id')
                    ->on('users_orig')
                    ->nullOnDelete();
            }
        });
    }
};