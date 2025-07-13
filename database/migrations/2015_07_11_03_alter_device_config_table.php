<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'login_with_code')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'login_with_code')) {
                    $table->text('login_with_code')->nullable()->after('reg_phone_first');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('login_with_code');
        });
    }
};


