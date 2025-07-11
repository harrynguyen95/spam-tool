<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'api_key_thuemails') || !Schema::hasColumn('last_configs', 'api_key_dongvanfb')) {
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'api_key_thuemails')) {
                    $table->text('api_key_thuemails')->nullable()->after('mail_suply');
                }
                if (!Schema::hasColumn('last_configs', 'api_key_dongvanfb')) {
                    $table->text('api_key_dongvanfb')->nullable()->after('mail_suply');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('api_key_thuemails');
            $table->dropColumn('api_key_dongvanfb');
        });
    }
};


