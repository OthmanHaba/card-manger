<?php

namespace App\Models;

use App\Enums\CardStatusEnum;
use App\Enums\WorkStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Card extends Model
{
    use HasFactory;
    use LogsActivity;

    protected function casts(): array
    {
        return [
            'matching_state' => CardStatusEnum::class,
            'status' => WorkStatusEnum::class,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        if (app()->runningInConsole()) {
            return LogOptions::defaults();
        }

        return LogOptions::defaults()
            ->logOnlyDirty() // Only log attributes that have changed
            ->useLogName('card_log')
            ->setDescriptionForEvent(function (string $eventName) {
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();

                    if (array_key_exists('status', $changes)) {
                        $oldValue = $this->getOriginal('status');
                        $newValue = WorkStatusEnum::from($changes['status']);

                        if ($oldValue instanceof WorkStatusEnum) {
                            $oldValue = $oldValue->getLabel();
                        }
                        if ($newValue instanceof WorkStatusEnum) {
                            $newValue = $newValue->getLabel();
                        }

                        return 'log.card.updated_work_status:'.json_encode([
                            'old' => $oldValue,
                            'new' => $newValue,
                        ]);
                    }

                    // Handle matching state changes
                    if (array_key_exists('matching_state', $changes)) {
                        $oldValue = $this->getOriginal('matching_state');
                        $newValue = CardStatusEnum::from($changes['matching_state']);

                        // Convert enum values to readable strings if needed
                        if ($oldValue instanceof CardStatusEnum) {
                            $oldValue = $oldValue->getLabel();
                        }

                        if ($newValue instanceof CardStatusEnum) {
                            $newValue = $newValue->getLabel();
                        }

                        // Store as a string with JSON-encoded parameters
                        return 'log.card.updated_matching_state:'.json_encode([
                            'old' => $oldValue,
                            'new' => $newValue,
                        ]);
                    }

                    // Check if both status fields were updated
                    if (array_key_exists('status', $changes) && array_key_exists('matching_state', $changes)) {
                        return 'log.card.updated_all_statuses';
                    }
                }

                // Fallback for other events or non-status updates
                return "log.card.{$eventName}";
            });
    }
}
