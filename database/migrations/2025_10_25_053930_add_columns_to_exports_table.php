<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('file_name');
            $table->integer('progress')->default(0)->after('status');
            $table->text('error_message')->nullable()->after('progress');
        });
    }

    public function down(): void
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'progress', 'error_message']);
        });
    }
};
