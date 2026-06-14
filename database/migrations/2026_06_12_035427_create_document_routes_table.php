<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('document_routes', function (Blueprint $table) {
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();

            $table->foreignId('from_office_id')->nullable()->constrained('offices')->nullOnDelete();
            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('to_office_id')->constrained('offices')->cascadeOnUpdate();
            $table->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('action_required');
            $table->string('delivery_type')->default('electronic');
            $table->dateTime('deadline')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('routed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('routed_at')->nullable();

            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('received_at')->nullable();

            $table->string('status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_routes');
    }
};
