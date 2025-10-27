<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        if (Schema::hasColumn('exports', 'nome_arquivo')) {
            Schema::table('exports', function (Blueprint $table) {
                $table->renameColumn('nome_arquivo', 'file_name');
            });
        }

        if (!Schema::hasColumn('exports', 'file_name')) {
            Schema::table('exports', function (Blueprint $table) {
                $table->string('file_name')->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('exports', 'file_name')) {
            Schema::table('exports', function (Blueprint $table) {
                $table->renameColumn('file_name', 'nome_arquivo');
            });
        }
    }
};
