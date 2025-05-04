<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة - بطاقة رقم {{ $card->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-gray-100 print:bg-white">
    <div class="max-w-4xl mx-auto my-8 bg-white p-10 border border-gray-200 shadow-sm print:shadow-none print:border-none print:my-0 print:p-0">
        <div class="flex justify-between items-center border-b-2 border-blue-600 pb-5 mb-8 print:border-black">
            <div class="text-right">
                <h2 class="text-3xl font-bold text-blue-600 mb-2 print:text-black">فاتورة</h2>
                <p class="font-semibold text-lg">المتوسط جروب</p>
                <p class="text-gray-600 text-sm">ALMOTAWASSET GROUP</p>
            </div>
            <div class="text-left">
                <img src="{{ asset('/PHOTO-2025-05-03-19-28-36.jpg') }}" alt="ALMOTAWASSET GROUP Logo" class="h-20 w-auto">
            </div>
        </div>

        <div class="mb-8 text-sm">
            <p><strong>رقم البطاقة (المرجع):</strong> {{ $card->id }}</p>
            <p><strong>تاريخ الإصدار:</strong> {{ now()->format('Y-m-d') }}</p>
            <p><strong>وقت الإصدار:</strong> {{ now()->format('H:i:s') }}</p>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 border-b pb-2">تفاصيل البطاقة</h3>
            <table class="w-full text-sm border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">الاسم</th>
                        <td class="w-2/3 text-right p-3">{{ $card->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">الرقم الوطني</th>
                        <td class="w-2/3 text-right p-3">{{ $card->national_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">رقم البطاقة</th>
                        <td class="w-2/3 text-right p-3">{{ $card->card_number }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">الرمز السري (PIN)</th>
                        <td class="w-2/3 text-right p-3">{{ $card->pin }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">رقم الحساب</th>
                        <td class="w-2/3 text-right p-3">{{ $card->account_number }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">رقم الهاتف</th>
                        <td class="w-2/3 text-right p-3">{{ $card->phone }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">حالة العمل</th>
                        <td class="w-2/3 text-right p-3">{{ $card->status?->getLabel() ?? $card->status }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">التصنيف (حالة المطابقة)</th>
                        <td class="w-2/3 text-right p-3">{{ $card->matching_state?->getLabel() ?? $card->matching_state }}</td>
                    </tr>
                    @if($card->notes)
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100">ملاحظات</th>
                        <td class="w-2/3 text-right p-3">{{ $card->notes }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="text-center mt-10 pt-5 border-t border-gray-200 text-xs text-gray-500">
        </div>
    </div>

    <div class="max-w-4xl mx-auto my-4 text-center print:hidden">
         <button onclick="window.print();" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
            طباعة الفاتورة
        </button>
    </div>
</body>
</html> 