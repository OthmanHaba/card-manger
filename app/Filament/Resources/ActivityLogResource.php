<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?int $navigationSort = 100;

    public static function getModelLabel(): string
    {
        return 'سجل النشاط';
    }

    public static function getPluralModelLabel(): string
    {
        return 'سجلات النشاط';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('تفاصيل النشاط')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('log_name')
                                    ->label('اسم السجل')
                                    ->content(fn(Activity $record): string => $record->log_name ?? 'افتراضي'),

                                Placeholder::make('event')
                                    ->label('الحدث')
                                    ->content(function (Activity $record) {
                                        // Translate standard events
                                        $events = [
                                            'created' => 'إنشاء',
                                            'updated' => 'تحديث',
                                            'deleted' => 'حذف',
                                        ];
                                        
                                        return $events[$record->event] ?? $record->event;
                                    }),

                                Placeholder::make('description')
                                    ->label('الوصف')
                                    ->content(fn(Activity $record): string => $record->description),

                                Placeholder::make('subject')
                                    ->label('العنصر المتأثر')
                                    ->content(function (Activity $record) {
                                        if (!$record->subject) {
                                            return 'غير متوفر';
                                        }
                                        
                                        $subject = $record->subject_type;
                                        if (method_exists($record->subject, 'getActivitySubjectDescription')) {
                                            return $record->subject->getActivitySubjectDescription();
                                        }
                                        
                                        // Try to find a name or title attribute
                                        $nameAttributes = ['name', 'title', 'label', 'id'];
                                        foreach ($nameAttributes as $attr) {
                                            if (isset($record->subject->$attr)) {
                                                return "{$subject}: {$record->subject->$attr}";
                                            }
                                        }
                                        
                                        return "{$subject} #{$record->subject_id}";
                                    }),

                                Placeholder::make('causer')
                                    ->label('المستخدم')
                                    ->content(function (Activity $record) {
                                        if (!$record->causer) {
                                            return 'نظام';
                                        }
                                        
                                        if (method_exists($record->causer, 'getActivityCauserDescription')) {
                                            return $record->causer->getActivityCauserDescription();
                                        }
                                        
                                        return $record->causer->name ?? ("مستخدم #{$record->causer_id}");
                                    }),

                                Placeholder::make('created_at')
                                    ->label('تاريخ النشاط')
                                    ->content(fn(Activity $record): string => $record->created_at->format('Y-m-d H:i:s')),
                            ]),

                        Card::make()
                            ->visible(fn(Activity $record) => $record->properties?->count() > 0)
                            ->schema([
                                Placeholder::make('properties')
                                    ->label('التفاصيل')
                                    ->content(function (Activity $record) {
                                        if ($record->properties?->count() <= 0) {
                                            return 'لا توجد بيانات إضافية';
                                        }
                                        
                                        // Special handling for status changes
                                        if ($record->properties->has('attributes') && $record->properties->has('old')) {
                                            $properties = $record->properties->toArray();
                                            $old = $properties['old'] ?? [];
                                            $new = $properties['attributes'] ?? [];
                                            
                                            $diff = [];
                                            
                                            // Create a detailed diff showing status changes
                                            foreach ($new as $key => $value) {
                                                if (!isset($old[$key]) || $old[$key] !== $value) {
                                                    $oldVal = $old[$key] ?? 'غير متوفر';
                                                    $newVal = $value;
                                                    
                                                    // Enhance display for status fields
                                                    if ($key === 'status' || $key === 'matching_state') {
                                                        $diff[] = "<strong>{$key}:</strong> تغيير من \"{$oldVal}\" إلى \"{$newVal}\"";
                                                    } else {
                                                        $diff[] = "<strong>{$key}:</strong> {$oldVal} → {$newVal}";
                                                    }
                                                }
                                            }
                                            
                                            // Format the diff as HTML
                                            return implode('<br>', $diff);
                                        }
                                        
                                        // Default display for other property types
                                        return view('filament.resources.activity-log-resource.properties', [
                                            'properties' => $record->properties,
                                        ])->render();
                                    }),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('الوصف')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('log_name')
                    ->label('نوع السجل')
                    ->searchable(),

                BadgeColumn::make('event')
                    ->label('الحدث')
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ])
                    ->formatStateUsing(function ($state) {
                        if (!$state) {
                            return '';
                        }
                        
                        return match ($state) {
                            'created' => 'إنشاء',
                            'updated' => 'تحديث',
                            'deleted' => 'حذف',
                            default => $state,
                        };
                    }),

                TextColumn::make('subject_type')
                    ->label('نوع العنصر')
                    ->formatStateUsing(function ($state) {
                        if (!$state) {
                            return '';
                        }
                        return Str::of($state)->afterLast('\\')->headline();
                    })
                    ->searchable(),
                
                // New column for status changes
                TextColumn::make('properties')
                    ->label('تغيير الحالة')
                    ->tooltip('يعرض تغييرات الحالة (من/إلى) للبطاقات')
                    ->formatStateUsing(function ($state, $record) {
                        // Add null check for $record
                        if (!$record) {
                            return null;
                        }
                        
                        // Check if this is a status update activity
                        if ($record->event === 'updated' && 
                            $state instanceof \Illuminate\Support\Collection && 
                            $state->has('attributes') && 
                            $state->has('old')) {
                            
                            $new = $state->get('attributes');
                            $old = $state->get('old');
                            $changes = [];
                            
                            // Check for status changes
                            if (isset($new['status']) && (!isset($old['status']) || $old['status'] !== $new['status'])) {
                                $oldValue = $old['status'] ?? 'غير محدد';
                                $newValue = $new['status'];
                                $changes[] = "<div class='py-1'>
                                    <span class='font-medium'>حالة العمل:</span> 
                                    <span class='text-red-500 dark:text-red-400'>{$oldValue}</span> 
                                    <span class='mx-1'>→</span> 
                                    <span class='text-green-500 dark:text-green-400'>{$newValue}</span>
                                </div>";
                            }
                            
                            // Check for matching_state changes
                            if (isset($new['matching_state']) && (!isset($old['matching_state']) || $old['matching_state'] !== $new['matching_state'])) {
                                $oldValue = $old['matching_state'] ?? 'غير محدد';
                                $newValue = $new['matching_state'];
                                $changes[] = "<div class='py-1'>
                                    <span class='font-medium'>حالة المطابقة:</span> 
                                    <span class='text-red-500 dark:text-red-400'>{$oldValue}</span> 
                                    <span class='mx-1'>→</span> 
                                    <span class='text-green-500 dark:text-green-400'>{$newValue}</span>
                                </div>";
                            }
                            
                            if (!empty($changes)) {
                                return implode('', $changes);
                            }
                        }
                        
                        return null; // Show nothing for non-status changes
                    })
                    ->html()
                    ->searchable(false)
                    ->sortable(false)
                    ->wrap() // Ensure text wraps properly
                    ->visible(function ($record) {
                        // Add null check
                        if (!$record) {
                            return false;
                        }
                        
                        return $record->event === 'updated' && 
                            $record->properties instanceof \Illuminate\Support\Collection && 
                            $record->properties->has('attributes') && 
                            $record->properties->has('old');
                    }),

                TextColumn::make('causer.name')
                    ->label('بواسطة')
                    ->placeholder('نظام'),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('log_name')
                    ->label('نوع السجل')
                    ->options(function () {
                        return Activity::query()
                            ->distinct('log_name')
                            ->pluck('log_name', 'log_name')
                            ->mapWithKeys(fn ($value, $key) => [$key => $value ?: 'افتراضي'])
                            ->toArray();
                    }),
                SelectFilter::make('event')
                    ->label('الحدث')
                    ->options([
                        'created' => 'إنشاء',
                        'updated' => 'تحديث',
                        'deleted' => 'حذف',
                    ]),
                SelectFilter::make('subject_type')
                    ->label('نوع العنصر')
                    ->options(function () {
                        return Activity::query()
                            ->distinct('subject_type')
                            ->whereNotNull('subject_type')
                            ->pluck('subject_type', 'subject_type')
                            ->mapWithKeys(fn ($value) => [$value => Str::of($value)->afterLast('\\')->headline()])
                            ->toArray();
                    }),
                // Add filter for status changes
                \Filament\Tables\Filters\Filter::make('status_changes')
                    ->label('تغييرات الحالة فقط')
                    ->query(function ($query) {
                        // A simpler approach that looks for activities with status-related keys in the description
                        return $query->where('event', 'updated')
                                    ->where(function ($q) {
                                        $q->where('description', 'like', '%status%')
                                          ->orWhere('description', 'like', '%matching_state%')
                                          ->orWhere('description', 'like', '%updated_status%')
                                          ->orWhere('description', 'like', '%card.updated_work_status%')
                                          ->orWhere('description', 'like', '%card.updated_matching_state%');
                                    });
                    })
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }
} 