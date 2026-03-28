<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Log an action.
     *
     * @param int|null $userId
     * @param string $action
     * @param string $entityType
     * @param int|null $entityId
     * @param array|null $changes
     * @return void
     */
    public static function log($userId, $action, $entityType, $entityId = null, $changes = null)
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log a model event automatically.
     *
     * @param string $event
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function logModelEvent($event, $model)
    {
        $userId = auth()->id();
        $changes = null;

        if ($event === 'updated') {
            $changes = [
                'before' => $model->getOriginal(),
                'after' => $model->getAttributes(),
            ];
        } elseif ($event === 'created') {
            $changes = ['after' => $model->getAttributes()];
        } elseif ($event === 'deleted') {
            $changes = ['before' => $model->getOriginal()];
        }

        self::log(
            $userId,
            $event,
            get_class($model),
            $model->getKey(),
            $changes
        );
    }
}
