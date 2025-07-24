<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'tsproxy_id')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'tsproxy_id')) {
                    $table->text('tsproxy_id')->nullable()->after('language');
                }
            });
        }
        if (!Schema::hasColumn('devices', 'tsproxy_port')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'tsproxy_port')) {
                    $table->text('tsproxy_port')->nullable()->after('tsproxy_id');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('tsproxy_id');
            $table->dropColumn('tsproxy_port');
        });
    }
};


