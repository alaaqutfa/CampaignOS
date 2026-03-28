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
        // Add indexes on foreign keys for campaigns
        Schema::table('campaigns', function (Blueprint $table) {
            $table->index('company_id');
            $table->index('created_by');
            $table->index('status');
            $table->index('due_date');
        });

        // Indexes for campaign_items (replaces campaign_measurements)
        Schema::table('campaign_items', function (Blueprint $table) {
            $table->index('campaign_id');
            $table->index('shop_id');
            $table->index('recorded_by');
            $table->index('status');
        });

        // Indexes for measurement_assets (replaces campaign_assets)
        Schema::table('measurement_assets', function (Blueprint $table) {
            $table->index('campaign_item_id');
            $table->index('type');
            $table->index('uploaded_by');
        });

        // Indexes for campaign_workflows
        Schema::table('campaign_workflows', function (Blueprint $table) {
            $table->index('campaign_id');
            $table->index('assigned_to');
            $table->index('status');
        });

        // Indexes for design_jobs
        Schema::table('design_jobs', function (Blueprint $table) {
            $table->index('campaign_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropIndex(['created_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('campaign_items', function (Blueprint $table) {
            $table->dropIndex(['campaign_id']);
            $table->dropIndex(['shop_id']);
            $table->dropIndex(['recorded_by']);
            $table->dropIndex(['status']);
        });

        Schema::table('measurement_assets', function (Blueprint $table) {
            $table->dropIndex(['campaign_item_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['uploaded_by']);
        });

        Schema::table('campaign_workflows', function (Blueprint $table) {
            $table->dropIndex(['campaign_id']);
            $table->dropIndex(['assigned_to']);
            $table->dropIndex(['status']);
        });

        Schema::table('design_jobs', function (Blueprint $table) {
            $table->dropIndex(['campaign_id']);
            $table->dropIndex(['status']);
        });
    }
};
