<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'reg_phone_first')) {
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'reg_phone_first')) {
                    $table->text('reg_phone_first')->nullable()->after('mail_suply');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('reg_phone_first');
        });
    }
};


