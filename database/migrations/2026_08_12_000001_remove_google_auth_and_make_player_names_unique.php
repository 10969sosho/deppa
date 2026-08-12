<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropUnique(['google_id']);
            }

            $columns = array_values(array_filter([
                Schema::hasColumn('users', 'google_id') ? 'google_id' : null,
                Schema::hasColumn('users', 'google_email') ? 'google_email' : null,
                Schema::hasColumn('users', 'google_avatar') ? 'google_avatar' : null,
            ]));

            if ($columns !== []) {
                $table->dropColumn($columns);
            }

            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });

        Schema::table('players', function (Blueprint $table): void {
            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table): void {
            $table->dropUnique(['nama']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('google_id')->nullable()->unique()->after('id');
            $table->string('google_email')->nullable()->after('email');
            $table->string('google_avatar')->nullable()->after('google_email');
        });
    }
};
