<?php

namespace App\Enums;

use App\Traits\Enummable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CardStatusEnum: string implements HasColor, HasLabel
{
    use Enummable;
    case NEW_CARD = 'new_card';
    case PENDING_APPROVAL = 'pending_approval';
    case APPROVED = 'approved';
    case NOT_APPROVED = 'not_approved';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NEW_CARD => Color::Gray,
            self::PENDING_APPROVAL => Color::Yellow,
            self::APPROVED => Color::Green,
            self::NOT_APPROVED => Color::Red,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEW_CARD => 'جديد',
            self::PENDING_APPROVAL => 'في انتضار المطابقة',
            self::APPROVED => 'مطابقة',
            self::NOT_APPROVED => 'غير مطابقة',
        };
    }
}
