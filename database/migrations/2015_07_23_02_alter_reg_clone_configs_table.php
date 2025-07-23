<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::connection('reg_clone')->hasColumn('configs', 'ip_rotate_mode')) { 
            Schema::connection('reg_clone')->table('configs', function (Blueprint $table) {
                if (!Schema::hasColumn('configs', 'ip_rotate_mode')) {
                    $table->text('ip_rotate_mode')->nullable()->after('change_info');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::connection('reg_clone')->table('configs', function (Blueprint $table) {
            $table->dropColumn('ip_rotate_mode');
        });
    }
};


