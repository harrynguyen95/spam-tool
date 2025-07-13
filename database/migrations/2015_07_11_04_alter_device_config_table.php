<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'mail_suply')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'mail_suply')) {
                    $table->text('mail_suply')->nullable()->after('note');
                }
                
            });
        }
        if (!Schema::hasColumn('devices', 'language')) { 
            Schema::table('devices', function (Blueprint $table) {
                if (!Schema::hasColumn('devices', 'language')) {
                    $table->text('language')->nullable()->after('note');
                }
                
            });
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('language');
            $table->dropColumn('mail_suply');
        });
    }
};


