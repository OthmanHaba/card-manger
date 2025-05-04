<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إيصال - {{ $card->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
             font-family: 'Cairo', 'Courier New', monospace, sans-serif; /* Prioritize readable Arabic font */
             line-height: 1.4;
        }
        @media print {
             /* Minimal print overrides */
             body {
                 -webkit-print-color-adjust: exact;
                 print-color-adjust: exact;
                 width: 72mm; /* Force width on print if @page doesn't work reliably */
                 min-width: 72mm !important;
                 padding: 3mm;
                 margin: 0;
             }
             /* Ensure content doesn't overflow */
             div, p, span, strong {
                 word-wrap: break-word;
                 overflow-wrap: break-word;
             }
        }
    </style>
</head>
{{-- Using text-xs for smaller font size suitable for thermal printers --}}
<body class="text-xs bg-white text-black p-2 print:p-0">
    <div class="text-center mb-2">
        <h2 class="font-bold text-sm">المتوسط جروب</h2>
        <p class="text-xs">ALMOTAWASSET GROUP</p>
        <p class="text-xs mt-1">إيصال بطاقة</p>
    </div>

    <div class="text-xs mb-2">
        <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }}</p>
        <p><strong>الوقت:</strong> {{ now()->format('H:i') }}</p>
    </div>

    <hr class="border-t border-dashed border-black my-2">

    <div class="text-xs space-y-1">
        {{-- Using simple paragraphs, adjust spacing/layout as needed --}}
        <p><strong class="mr-2">الاسم:</strong>{{ $card->name }}</p>
        <p><strong class="mr-2">رقم البطاقة:</strong>{{ $card->card_number }}</p>
        <p><strong class="mr-2">الرقم الوطني:</strong>{{ $card->national_id }}</p>
        <p><strong class="mr-2">الهاتف:</strong>{{ $card->phone }}</p>
         {{-- Add other essential details if needed --}}
    </div>

    <hr class="border-t border-dashed border-black my-2">

    <div class="text-center text-xs mt-2">
        <p>شكراً لك!</p>
    </div>

    {{-- Auto-print script --}}
    <script class="print:hidden">
        window.onload = function() {
            window.print();
            // setTimeout(function() { window.close(); }, 500);
        }
    </script>
</body>
</html> 