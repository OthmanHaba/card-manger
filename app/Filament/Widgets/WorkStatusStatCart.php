<?php

namespace App\Filament\Widgets;

use App\Enums\WorkStatusEnum;
use App\Models\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkStatusStatCart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(WorkStatusEnum::BOOKED->getLabel(), Card::where('status', WorkStatusEnum::BOOKED)->count())
                ->description('عدد البطاقات المحجوزة')
                ->icon('heroicon-o-bookmark')
                ->color(WorkStatusEnum::BOOKED->getColor()),

            Stat::make(WorkStatusEnum::DEPOSITED->getLabel(), Card::where('status', WorkStatusEnum::DEPOSITED)->count())
                ->description('عدد البطاقات المودعة')
                ->icon('heroicon-o-banknotes')
                ->color(WorkStatusEnum::DEPOSITED->getColor()),

            Stat::make(WorkStatusEnum::COMPLETED->getLabel(), Card::where('status', WorkStatusEnum::COMPLETED)->count())
                ->description('عدد البطاقات المكتملة')
                ->icon('heroicon-o-check-circle')
                ->color(WorkStatusEnum::COMPLETED->getColor()),
        ];
    }
} 