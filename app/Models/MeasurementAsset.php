<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementAsset extends Model
{
    use HasFactory;

    protected $table = 'measurement_assets'; // تغيير اسم الجدول

    protected $fillable = [
        'campaign_item_id',
        'type',          // 'before' or 'after'
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'uploaded_by',
        'captured_at',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'size'        => 'integer',
    ];

    public function campaignItem(): BelongsTo
    {
        return $this->belongsTo(CampaignItem::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
