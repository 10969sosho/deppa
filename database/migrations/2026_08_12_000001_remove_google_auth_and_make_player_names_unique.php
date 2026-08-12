<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        $this->numberDuplicatePlayerNames();

        Schema::table('players', function (Blueprint $table): void {
            $table->unique('nama');
        });
    }

    private function numberDuplicatePlayerNames(): void
    {
        $players = DB::table('players')
            ->orderBy('id')
            ->get(['id', 'nama']);
        $occupiedNames = [];
        $seenNames = [];

        foreach ($players as $player) {
            $normalizedName = mb_strtolower($player->nama);

            if (! isset($seenNames[$normalizedName])) {
                $seenNames[$normalizedName] = 1;
                $occupiedNames[$normalizedName] = true;

                continue;
            }

            $suffix = $seenNames[$normalizedName];

            do {
                $candidate = $this->numberedName($player->nama, $suffix);
                $candidateKey = mb_strtolower($candidate);
                $suffix++;
            } while (isset($occupiedNames[$candidateKey]));

            DB::table('players')
                ->where('id', $player->id)
                ->update(['nama' => $candidate]);

            $seenNames[$normalizedName] = $suffix;
            $occupiedNames[$candidateKey] = true;
        }
    }

    private function numberedName(string $name, int $suffix): string
    {
        $suffixText = ' '.$suffix;
        $baseLength = 100 - mb_strlen($suffixText);

        return rtrim(mb_substr($name, 0, $baseLength)).$suffixText;
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
