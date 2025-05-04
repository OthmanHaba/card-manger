<div>
    @if ($properties instanceof \Illuminate\Support\Collection && $properties->count() > 0)
        <div class="space-y-4">
            @foreach ($properties as $key => $property)
                @if ($key === 'attributes' || $key === 'old')
                    @continue
                @endif
                
                @if (is_array($property) || $property instanceof \Illuminate\Support\Collection)
                    <div>
                        <h3 class="text-lg font-medium">{{ $key }}</h3>
                        <div class="mt-2 bg-gray-50 p-4 rounded-lg dark:bg-gray-800">
                            @foreach ($property as $propertyKey => $propertyValue)
                                <div class="mb-2">
                                    <span class="font-semibold">{{ $propertyKey }}:</span>
                                    
                                    @if (is_array($propertyValue) || $propertyValue instanceof \Illuminate\Support\Collection)
                                        <pre class="whitespace-pre-wrap break-words mt-1">{{ json_encode($propertyValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        <span>{{ $propertyValue }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div>
                        <span class="font-semibold">{{ $key }}:</span> {{ $property }}
                    </div>
                @endif
            @endforeach
            
            {{-- Special handler for comparing old and new values --}}
            @if ($properties->has('attributes') && $properties->has('old'))
                <div>
                    <h3 class="text-lg font-medium">التغييرات</h3>
                    <div class="mt-2 bg-gray-50 p-4 rounded-lg dark:bg-gray-800">
                        @php
                            $new = $properties->get('attributes');
                            $old = $properties->get('old');
                            
                            // Status field names - highlight these changes
                            $statusFields = ['status', 'matching_state'];
                        @endphp
                        
                        @foreach ($new as $key => $value)
                            @if (!isset($old[$key]) || $old[$key] !== $value)
                                <div class="mb-3 pb-2 @if(in_array($key, $statusFields)) bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-md @endif">
                                    <div class="font-semibold 
                                        @if(in_array($key, $statusFields)) text-yellow-700 dark:text-yellow-400 @endif">
                                        {{ $key }}:
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 mt-1">
                                        <div>
                                            <span class="text-red-500 font-medium">القيمة القديمة:</span>
                                            <div class="mt-1">{{ $old[$key] ?? 'لا شيء' }}</div>
                                        </div>
                                        
                                        <div>
                                            <span class="text-green-500 font-medium">القيمة الجديدة:</span>
                                            <div class="mt-1">{{ $value }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="text-gray-500">لا توجد بيانات إضافية</div>
    @endif
</div> 