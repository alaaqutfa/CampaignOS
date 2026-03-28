<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contractor_region_assignments', function (Blueprint $table) {
            $table->foreignId('region_id')
                ->nullable()
                ->after('city_id')
                ->constrained('regions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('contractor_region_assignments', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
