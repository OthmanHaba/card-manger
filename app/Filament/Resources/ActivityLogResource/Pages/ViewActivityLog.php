<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    protected static ?string $title = 'عرض النشاط';

    public function getBreadcrumb(): string
    {
        return $this->record->id;
    }

    public function getRecordTitle(): string|Htmlable
    {
        return 'النشاطات';
    }
}
