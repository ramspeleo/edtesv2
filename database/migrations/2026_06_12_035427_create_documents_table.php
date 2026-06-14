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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('tracking_number')->unique()->after('id');
            $table->string('reference_number')->nullable()->after('tracking_number');

            $table->foreignId('document_type_id')->constrained('document_types')->cascadeOnUpdate();
            $table->date('document_date')->nullable();

            $table->string('subject');
            $table->text('description')->nullable();

            $table->foreignId('origin_office_id')->constrained('offices')->cascadeOnUpdate();
            $table->foreignId('origin_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('current_office_id')->nullable()->constrained('offices')->nullOnDelete();
            $table->foreignId('current_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('priority')->default('normal');
            $table->string('confidentiality')->default('internal');
            $table->string('status')->default('registered');

            $table->string('main_document_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
