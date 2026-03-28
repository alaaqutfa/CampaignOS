<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'created_by',
        'template_name',
        'input_payload',
        'output_file',
        'status',
        'error_message',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'input_payload' => 'array',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
