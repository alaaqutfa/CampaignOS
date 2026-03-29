<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles,HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'is_super_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_super_admin'    => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }

    public function createdCampaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function reportedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'reported_by');
    }

    public function recordedMeasurements(): HasMany
    {
        return $this->hasMany(CampaignItem::class, 'recorded_by');
    }

    public function installedMeasurements(): HasMany
    {
        return $this->hasMany(CampaignItem::class, 'installed_by');
    }

    public function uploadedAssets(): HasMany
    {
        return $this->hasMany(MeasurementAsset::class, 'uploaded_by');
    }

    public function assignedRegions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'contractor_region_assignments', 'user_id', 'region_id')
            ->withPivot('assignment_type')
            ->withTimestamps();
    }

    public function measurementTasks(): HasMany
    {
        return $this->hasMany(CampaignItem::class, 'assigned_measurer_id');
    }

    public function installationTasks(): HasMany
    {
        return $this->hasMany(CampaignItem::class, 'assigned_installer_id');
    }
}
