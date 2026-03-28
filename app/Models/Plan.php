<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'user_limit',
        'campaign_limit',
        'storage_limit',
        'features',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'features'   => 'array',
        'is_popular' => 'boolean',
        'is_active'  => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 2) . ' ' . ($this->billing_cycle === 'monthly' ? 'SAR/month' : 'SAR/year');
    }
}
