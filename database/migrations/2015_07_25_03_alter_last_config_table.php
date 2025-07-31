<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'api_key_ironsim')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'api_key_ironsim')) {
                    $table->text('api_key_ironsim')->nullable()->after('api_key_gmail66');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('api_key_ironsim');
        });
    }
};


