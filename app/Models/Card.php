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
        return LogOptions::defaults();
    }
}
