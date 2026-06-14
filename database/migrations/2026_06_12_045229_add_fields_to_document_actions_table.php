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
        Schema::table('document_actions', function (Blueprint $table) {
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('document_route_id')->nullable()->constrained('document_routes')->nullOnDelete();

            $table->foreignId('acted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('action_taken');
            $table->text('remarks')->nullable();

            $table->dateTime('acted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_actions');
    }
};
