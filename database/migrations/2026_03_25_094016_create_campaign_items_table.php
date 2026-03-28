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
        Schema::create('campaign_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('restrict'); // المحل الذي سيوضع فيه المطبوع
            $table->string('material');                                        // مادة الطباعة (Mesh, Sticker, ...)
            $table->integer('quantity')->default(1);                           // الكمية
            $table->decimal('width', 10, 2);                                   // العرض
            $table->decimal('height', 10, 2);                                  // الارتفاع
            $table->string('unit')->default('cm');                             // الوحدة (cm, inch, pixel)
            $table->text('text')->nullable();                                  // النص العربي الذي سيطبع (مثلاً اسم المحل)
            $table->string('print_file_name')->nullable();                     // اسم ملف الطباعة (قد يُولّد تلقائياً)
            $table->decimal('sqm', 10, 2)->nullable();                         // المساحة (عرض×ارتفاع×كمية)/10000 – يمكن حسابها عند الحفظ
            $table->enum('status', ['pending', 'measured', 'designed', 'printed', 'installed', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('installed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('installed_at')->nullable();
            $table->text('notes')->nullable(); // ملاحظات عامة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_items');
    }
};
