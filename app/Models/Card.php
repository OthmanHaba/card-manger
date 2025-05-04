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

    // Make sure fillable includes attributes you want logged on creation/update
    // protected $fillable = ['name', 'description', 'matching_state', 'status', ...];

    protected function casts(): array
    {
        return [
            'matching_state' => CardStatusEnum::class,
            'status' => WorkStatusEnum::class,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        if(app()->runningInConsole()) {
            return LogOptions::defaults();
        }

        return LogOptions::defaults()
            ->logOnlyDirty() // Only log attributes that have changed
            ->useLogName('card_log')
            ->setDescriptionForEvent(function(string $eventName) {
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    
                    // Handle status changes with more details
                    if (array_key_exists('status', $changes)) {
                        $oldValue = $this->getOriginal('status');
                        $newValue = $changes['status'];
                        
                        // Convert enum values to readable strings if needed
                        if ($oldValue instanceof WorkStatusEnum) {
                            $oldValue = $oldValue->value;
                        }
                        if ($newValue instanceof WorkStatusEnum) {
                            $newValue = $newValue->value;
                        }
                        
                        // Log with translation key that can include old and new values
                        return [
                            'log.card.updated_work_status', 
                            [
                                'old' => $oldValue,
                                'new' => $newValue
                            ]
                        ];
                    }
                    
                    // Handle matching state changes
                    if (array_key_exists('matching_state', $changes)) {
                        $oldValue = $this->getOriginal('matching_state');
                        $newValue = $changes['matching_state'];
                        
                        // Convert enum values to readable strings if needed
                        if ($oldValue instanceof CardStatusEnum) {
                            $oldValue = $oldValue->value;
                        }
                        if ($newValue instanceof CardStatusEnum) {
                            $newValue = $newValue->value;
                        }
                        
                        // Log with translation key that can include old and new values
                        return [
                            'log.card.updated_matching_state', 
                            [
                                'old' => $oldValue,
                                'new' => $newValue
                            ]
                        ];
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
