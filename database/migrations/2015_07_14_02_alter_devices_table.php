<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'count_line')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'count_line')) {
                    $table->text('count_line')->nullable()->after('note');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('count_line');
        });
    }
};


