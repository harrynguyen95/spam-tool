<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'username') || !Schema::hasColumn('devices', 'note')) {
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'username')) {
                    $table->text('username')->nullable()->after('ip_address');
                }
                if (!Schema::hasColumn('devices', 'note')) {
                    $table->text('note')->nullable()->after('ip_address');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('note');
        });
    }
};


