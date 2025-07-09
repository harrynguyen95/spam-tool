<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('last_configs', function (Blueprint $table) {
            $table->id();
            $table->string('language')->nullable();
            $table->string('mail_suply')->nullable();
            $table->string('proxy')->nullable();
            $table->string('hotmail_service_ids')->nullable();
            $table->string('enter_verify_code')->nullable();
            $table->string('hot_mail_source_from_file')->nullable();
            $table->string('thue_lai_mail_thuemails')->nullable();
            $table->string('add_mail_domain')->nullable();
            $table->string('remove_register_mail')->nullable();
            $table->string('provider_mail_thuemails')->nullable();
            $table->string('times_xoa_info')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_configs');
    }
};
