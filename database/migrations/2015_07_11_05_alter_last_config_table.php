<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'mail_suply')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'mail_suply')) {
                    $table->text('mail_suply')->nullable()->after('note');
                }
                
            });
        }
        if (!Schema::hasColumn('last_configs', 'language')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'language')) {
                    $table->text('language')->nullable()->after('note');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('language');
            $table->dropColumn('mail_suply');
        });
    }
};


