<?php

namespace App\Filament\Resources;

use App\Enums\CardStatusEnum;
use App\Enums\WorkStatusEnum;
use App\Filament\Resources\CardResource\Pages;
use App\Models\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $slug = 'cards';

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function getModelLabel(): string
    {
        return 'البطاقة';
    }

    public static function getPluralModelLabel(): string
    {
        return 'البطاقات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('معلومات البطاقة')
                    ->description('تفاصيل البطاقة الأساسية')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name')
                                    ->label('الاسم')
                                    ->required(),

                                TextInput::make('national_id')
                                    ->label('الرقم الوطني')
                                    ->required(),

                                TextInput::make('card_number')
                                    ->label('رقم البطاقة')
                                    ->required(),

                                TextInput::make('pin')
                                    ->label('الرمز السري')
                                    ->required(),

                                Select::make('status')
                                    ->options(
                                        WorkStatusEnum::class
                                    )
                                    ->label('الحالة')
                                    ->required(),

                                Select::make('matching_state')
                                    ->options(CardStatusEnum::class)
                                    ->label('حالة المطابقة')
                                    ->required(),

                                TextInput::make('phone')
                                    ->label('رقم الهاتف')
                                    ->required(),

                                TextInput::make('account_number')
                                    ->label('رقم الحساب')
                                    ->required(),

                            ]),

                    ]),

                Section::make('ملاحظات إضافية')
                    ->schema([
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('national_id')->label('الرقم الوطنية'),

                TextColumn::make('phone')->label('الهاتف'),

                TextColumn::make('card_number')->label('رقم البطاقة'),

                TextColumn::make('status')
                    ->badge()
                    ->label('الحالة'),

                TextColumn::make('matching_state')
                    ->badge()
                    ->label('التصنيف'),

                TextColumn::make('notes')
                    ->label('ملاحظات'),

                TextColumn::make('purchase_price')
                    ->label('سعر الشراء'),

                TextColumn::make('account_number')
                    ->label('رقم الحساب'),

            ])
            ->groups([
                Group::make('matching_state')
                    ->label('التصنيف'),
                Group::make('status')
                    ->label('حالة العمل'),
            ])
            ->defaultGroup('matching_state')
            ->groupingDirectionSettingHidden()
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('changeStatus')
                    ->label('تغيير الحالة')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->modalHeading('تغيير حالة العمل')
                    ->form([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(WorkStatusEnum::class)
                            ->required()
                    ])
                    ->action(function (Card $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    }),
                Action::make('changeMatchingState')
                    ->label('تغيير التصنيف')
                    ->icon('heroicon-o-tag')
                    ->color('success')
                    ->modalHeading('تغيير التصنيف')
                    ->form([
                        Select::make('matching_state')
                            ->label('التصنيف')
                            ->options(CardStatusEnum::class)
                            ->required()
                    ])
                    ->action(function (Card $record, array $data): void {
                        $record->update([
                            'matching_state' => $data['matching_state'],
                        ]);
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
