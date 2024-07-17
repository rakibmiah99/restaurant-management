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
            $table->string('username')->nullable()->default(null)->after('name');
            $table->string('phone')->nullable()->default(null)->after('email');
            $table->string('company_name')->nullable()->default(null)->after('email');
            $table->string('location')->nullable()->default(null)->after('company_name');
            $table->string('website')->nullable()->default(null)->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('phone');
            $table->dropColumn('company_name');
            $table->dropColumn('location');
            $table->dropColumn('website');
        });
    }
};
