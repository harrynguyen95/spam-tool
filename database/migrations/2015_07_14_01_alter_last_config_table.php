<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('last_configs', 'local_server')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'local_server')) {
                    $table->text('local_server')->nullable()->after('login_with_code');
                }
                
            });
        }
        if (!Schema::hasColumn('last_configs', 'destination_filename')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'destination_filename')) {
                    $table->text('destination_filename')->nullable()->after('login_with_code');
                }
            });
        }
        if (!Schema::hasColumn('last_configs', 'source_filepath')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'source_filepath')) {
                    $table->text('source_filepath')->nullable()->after('login_with_code');
                }
            });
        }
        if (!Schema::hasColumn('last_configs', 'separate_items')) { 
            Schema::table('last_configs', function (Blueprint $table) {
                if (!Schema::hasColumn('last_configs', 'separate_items')) {
                    $table->text('separate_items')->nullable()->after('login_with_code');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('last_configs', function (Blueprint $table) {
            $table->dropColumn('local_server');
            $table->dropColumn('destination_filename');
            $table->dropColumn('source_filepath');
            $table->dropColumn('separate_items');
        });
    }
};


