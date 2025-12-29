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
            $table->string('student_id')->unique()->after('password');
            $table->string('phone')->after('student_id');
            $table->string('batch')->after('phone');
            $table->enum('identity', ['student', 'lecturer'])->after('batch');
            $table->string('id_photo')->nullable()->after('identity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['student_id', 'phone', 'batch', 'identity', 'id_photo']);
        });
    }
};
