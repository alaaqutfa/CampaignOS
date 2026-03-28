<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaign_items', function (Blueprint $table) {
            $table->foreignId('assigned_measurer_id')
                ->nullable()
                ->after('recorded_by')
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('assigned_installer_id')
                ->nullable()
                ->after('assigned_measurer_id')
                ->constrained('users')
                ->nullOnDelete();
            $table->text('failure_reason')
                ->nullable()
                ->after('rejection_reason');
        });
    }

    public function down(): void
    {
        Schema::table('campaign_items', function (Blueprint $table) {
            $table->dropForeign(['assigned_measurer_id']);
            $table->dropForeign(['assigned_installer_id']);
            $table->dropColumn(['assigned_measurer_id', 'assigned_installer_id', 'failure_reason']);
        });
    }
};
