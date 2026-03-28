<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'client_name',
        'location',
        'status',
        'priority',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // مرادف لـ createdBy للاستخدام في الـ views
    public function creator(): BelongsTo
    {
        return $this->createdBy();
    }

    public function items(): HasMany
    {
        return $this->hasMany(CampaignItem::class);
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    // العلاقة مع المقاولين المعينين (اختياري)
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_assignments')
            ->withPivot('role')
            ->withTimestamps();
    }
}
