<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignItem extends Model
{
    use HasFactory;

    protected $table = 'campaign_items'; // تغيير اسم الجدول

    protected $fillable = [
        'campaign_id',
        'assigned_measurer_id',
        'assigned_installer_id',
        'shop_id',
        'material',
        'quantity',
        'width',
        'height',
        'unit',
        'text',
        'print_file_name',
        'sqm',
        'status',
        'rejection_reason',
        'failure_reason',
        'recorded_by',
        'installed_by',
        'installed_at',
        'notes',
    ];

    protected $casts = [
        'quantity'     => 'integer',
        'width'        => 'decimal:2',
        'height'       => 'decimal:2',
        'sqm'          => 'decimal:2',
        'installed_at' => 'datetime',
    ];

    // العلاقات
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function installedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'installed_by');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(MeasurementAsset::class, 'campaign_item_id');
    }

    public function getSqmAttribute()
    {
        return ($this->width * $this->height * $this->quantity) / 10000;
    }

    public function scopeForMeasurer($query, $userId)
    {
        return $query->where('assigned_measurer_id', $userId);
    }

    public function scopeForInstaller($query, $userId)
    {
        return $query->where('assigned_installer_id', $userId);
    }

    public function assignedMeasurer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_measurer_id');
    }

    public function assignedInstaller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_installer_id');
    }
}
