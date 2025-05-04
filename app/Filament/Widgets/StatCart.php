<?php

namespace App\Filament\Widgets;

use App\Enums\CardStatusEnum;
use App\Enums\WorkStatusEnum;
use App\Models\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatCart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي البطاقات', Card::count())
                ->description('مجموع كل البطاقات')
                ->icon('heroicon-o-credit-card')
                ->color('primary'),

            Stat::make(CardStatusEnum::NEW_CARD->getLabel(), Card::where('matching_state', CardStatusEnum::NEW_CARD)->count())
                ->description('عدد البطاقات الجديدة')
                ->icon('heroicon-o-sparkles')
                ->color(CardStatusEnum::NEW_CARD->getColor()),

            Stat::make(CardStatusEnum::PENDING_APPROVAL->getLabel(), Card::where('matching_state', CardStatusEnum::PENDING_APPROVAL)->count())
                ->description('عدد البطاقات في انتظار المطابقة')
                ->icon('heroicon-o-clock')
                ->color(CardStatusEnum::PENDING_APPROVAL->getColor()),

            Stat::make(CardStatusEnum::APPROVED->getLabel(), Card::where('matching_state', CardStatusEnum::APPROVED)->count())
                ->description('عدد البطاقات المطابقة')
                ->icon('heroicon-o-check-badge')
                ->color(CardStatusEnum::APPROVED->getColor()),

            Stat::make(CardStatusEnum::NOT_APPROVED->getLabel(), Card::where('matching_state', CardStatusEnum::NOT_APPROVED)->count())
                ->description('عدد البطاقات غير المطابقة')
                ->icon('heroicon-o-x-circle')
                ->color(CardStatusEnum::NOT_APPROVED->getColor()),
        ];
    }
}
