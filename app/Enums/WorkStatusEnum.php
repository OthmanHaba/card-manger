<?php

namespace App\Enums;

use App\Traits\Enummable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WorkStatusEnum: string implements HasColor, HasLabel
{
    use Enummable;
    case NEW = 'new';
    case BOOKED = 'booked';
    case DEPOSITED = 'deposited';
    case COMPLETED = 'completed';

    public function getLabel(): string
    {
        return match ($this) {
            self::BOOKED => 'تم الحجز',
            self::DEPOSITED => 'تم الإيداع',
            self::COMPLETED => 'تم الانتهاء',
            self::NEW => 'جديدة',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BOOKED => Color::Green,
            self::DEPOSITED => Color::Yellow,
            self::COMPLETED => Color::Blue,
            self::NEW => Color::Gray,
        };
    }
}
