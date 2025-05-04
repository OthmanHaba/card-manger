<?php

namespace App\Filament\Resources\CardResource\Pages;

use App\Filament\Resources\CardResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

class CreateCard extends CreateRecord
{
    protected static string $resource = CardResource::class;

    protected static bool $canCreateAnother = false;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $card = $this->record;

        Notification::make()
            ->success()
            ->title('تم إنشاء البطاقة بنجاح')
            ->body('هل تريد طباعة الفاتورة الكاملة؟')
            ->actions([
                Action::make('print_full')
                    ->label('نعم، طباعة الفاتورة الكاملة')
                    ->button()
                    ->url(route('print.full.invoice', $card), shouldOpenInNewTab: true)
                    ->close(),

                Action::make('ask_small')
                    ->label('لا، اسأل عن الفاتورة الصغيرة')
                    ->button()
                    ->color('gray')
                    ->action(function () use ($card) {
                        $this->askToPrintSmallInvoice($card);
                    })
                    ->close(),
            ])
            ->persistent()
            ->send();

        throw new Halt();
    }

    protected function askToPrintSmallInvoice(Model $card): void
    {
        Notification::make()
            ->success()
            ->title('طباعة الفاتورة الصغيرة')
            ->body('هل تريد طباعة الفاتورة الصغيرة للطابعة الحرارية؟')
            ->actions([
                Action::make('print_small')
                    ->label('نعم، طباعة الفاتورة الصغيرة')
                    ->button()
                    ->url(route('print.small.invoice', $card), shouldOpenInNewTab: true)
                    ->close(),

                Action::make('cancel_small')
                    ->label('لا، شكراً')
                    ->button()
                    ->color('gray')
                    ->close(),
            ])
            ->persistent()
            ->sendToDatabase(auth()->user())
            ->send();

        $this->redirect($this->getRedirectUrl());
    }
}
