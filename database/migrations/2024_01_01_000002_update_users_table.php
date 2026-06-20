<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->nullable()->after('email');
            $table->boolean('phone_verified')->default(false)->after('phone');
            $table->string('profile_image')->nullable()->after('phone_verified');
            $table->string('role')->default('user')->after('profile_image');
            $table->unsignedBigInteger('department_id')->nullable()->after('role');
            $table->string('position')->nullable()->after('department_id');
            $table->string('google_id')->nullable()->after('position');
            $table->string('google_token')->nullable()->after('google_id');
            
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['phone', 'phone_verified', 'profile_image', 'role', 'department_id', 'position', 'google_id', 'google_token']);
        });
    }
};