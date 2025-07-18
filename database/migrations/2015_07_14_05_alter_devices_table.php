<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'account_region')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'account_region')) {
                    $table->text('account_region')->nullable()->after('language');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('account_region');
        });
    }
};


