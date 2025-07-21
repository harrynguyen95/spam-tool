<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::connection('reg_clone')->hasColumn('configs', 'change_info')) { 
            Schema::connection('reg_clone')->table('configs', function (Blueprint $table) {
                if (!Schema::hasColumn('configs', 'change_info')) {
                    $table->text('change_info')->nullable()->after('enter_verify_code');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::connection('reg_clone')->table('configs', function (Blueprint $table) {
            $table->dropColumn('change_info');
        });
    }
};


