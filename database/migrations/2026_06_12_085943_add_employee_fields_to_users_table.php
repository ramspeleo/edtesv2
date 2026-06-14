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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('id');

            $table->string('fname', 100)->nullable()->after('name');
            $table->string('mname', 100)->nullable()->after('fname');
            $table->string('lname', 100)->nullable()->after('mname');
            $table->string('extension', 45)->nullable()->after('lname');

            $table->string('mobile_no', 20)->nullable()->after('remember_token');
            $table->string('emp_no', 100)->nullable()->after('mobile_no');
            $table->string('emp_type', 100)->nullable()->after('emp_no');
            $table->string('emp_title', 100)->nullable()->after('emp_type');

            $table->string('region_code', 100)->nullable()->after('emp_title');
            $table->string('department_code', 100)->nullable()->after('region_code');
            $table->string('office_code', 100)->nullable()->after('department_code');

            $table->enum('status', [
                'active',
                'inactive',
                'suspended'
            ])->default('active')->after('office_code');

            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();

            $table->dropColumn([
                'profile_photo',
                'fname',
                'mname',
                'lname',
                'extension',
                'mobile_no',
                'emp_no',
                'emp_type',
                'emp_title',
                'region_code',
                'department_code',
                'office_code',
                'status',
                'last_login_at',
                'last_login_ip',
            ]);
        });
    }
};
