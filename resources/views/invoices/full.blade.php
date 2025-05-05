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
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4;
                margin: 0.5cm;
            }
            .qr-code {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body class="bg-gray-100 print:bg-white">
    <div class="max-w-4xl mx-auto my-8 bg-white p-10 border border-gray-200 shadow-sm print:shadow-none print:border-none print:my-0 print:p-4">
        <div class="flex justify-between items-center border-b-2 border-blue-600 pb-5 mb-6 print:pb-3 print:mb-4 print:border-black">
            <div class="text-right">
                <h2 class="text-3xl font-bold text-blue-600 mb-2 print:text-black print:text-2xl">فاتورة</h2>
                <p class="font-semibold text-lg print:text-base">المتوسط جروب</p>
                <p class="text-gray-600 text-sm">ALMOTAWASSET GROUP</p>
            </div>
            <div class="text-left">
                <img src="{{ asset('/PHOTO-2025-05-03-19-28-36.jpg') }}" alt="ALMOTAWASSET GROUP Logo" class="h-20 w-auto print:h-16">
            </div>
        </div>

        <div class="mb-6 text-sm print:mb-3">
            <p><strong>رقم البطاقة (المرجع):</strong> {{ $card->id }}</p>
            <p><strong>تاريخ الإصدار:</strong> {{ now()->format('Y-m-d') }}</p>
            <p><strong>وقت الإصدار:</strong> {{ now()->format('H:i:s') }}</p>
        </div>

        <div class="mb-6 print:mb-3">
            <h3 class="text-xl font-semibold mb-3 border-b pb-2 print:text-lg print:mb-2 print:pb-1">تفاصيل البطاقة</h3>
            <table class="w-full text-sm border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100 print:p-2">الاسم</th>
                        <td class="w-2/3 text-right p-3 print:p-2">{{ $card->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100 print:p-2">الرقم الوطني</th>
                        <td class="w-2/3 text-right p-3 print:p-2">{{ $card->national_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="w-1/3 text-right font-semibold p-3 bg-gray-100 print:bg-gray-100 print:p-2">رقم البطاقة</th>
                        <td class="w-2/3 text-right p-3 print:p-2">{{ $card->card_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-200 print:mt-2 print:pt-2">
            <div class="flex justify-between items-start">
                <div class="text-right w-2/3">
                    <div class="mb-3 print:mb-2">
                        <p class="font-bold mb-1 print:text-sm">معلومات التواصل</p>
                        <div class="space-y-1">
                            <p class="text-sm print:text-xs">
                                <span class="font-medium">رقم الهاتف:</span>
                                <span>0945656641</span>
                            </p>
                            <p class="text-sm print:text-xs">
                                <span class="font-medium">العنوان:</span>
                                <span>سوق المشير مقابل السرايا الحمرة المتوسط جروب</span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm mb-1 print:text-sm">تعليمات هامة</p>
                        <div class="text-sm print:text-xs">
                            <p>
                                لا يتم تسليم الجواز إلا بالوصل الأصلي أو حضور صاحب المعاملة شخصياً
                            </p>
                            <p>
                                مهلة بقاء الجواز 15 يوماً - لا يتم المطالبة به قبل ذلك
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-1/3 flex justify-center items-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=عنوان المحل : سوق المشير مقابل السرايا الحمرة المتوسط جروب    https://maps.app.goo.gl/3fPR9aPtc9EwxrWz6" alt="QR Code" class="qr-code w-24 h-24 print:w-20 print:h-20">
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto my-4 text-center print:hidden">
         <button onclick="window.print();" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
            طباعة الفاتورة
        </button>
    </div>
</body>
</html>
