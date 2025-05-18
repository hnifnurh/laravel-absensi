<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    protected $connection = 'users_mysql';

    public function up(): void
    {
        Schema::connection('users_mysql')->table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('users_mysql')->table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
