<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إيصال - {{ $card->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: 60mm 90mm;
            margin: 0;
        }
        html, body {
            width: 60mm;
            max-width: 60mm;
            height: 90mm;
            max-height: 90mm;
            margin: 0;
            padding: 2mm;
            font-family: 'Cairo', 'Courier New', monospace, sans-serif;
            line-height: 1.4;
            font-size: 9px;
        }
        div, p, span, strong {
            word-wrap: break-word;
            overflow-wrap: break-word;
            margin-bottom: 1mm;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 1.5mm 0;
        }
        @media print {
            html, body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                width: 60mm !important;
                height: 90mm !important;
                margin: 0 !important;
                padding: 2mm !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 1.5mm;">
        <h2 style="font-weight: bold; font-size: 11px;">المتوسط جروب</h2>
        <p>ALMOTAWASSET GROUP</p>
        <p style="margin-top: 0.5mm;">إيصال بطاقة</p>
    </div>

    <div style="margin-bottom: 1.5mm;">
        <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }}</p>
        <p><strong>الوقت:</strong> {{ now()->format('H:i') }}</p>
    </div>

    <div class="divider"></div>

    <div style="margin-bottom: 1.5mm;">
        <p><strong style="margin-left: 1mm;">الاسم:</strong>{{ $card->name }}</p>
        <p><strong style="margin-left: 1mm;">الرقم السري للبطاقة:</strong>{{ $card->pin }}</p>
        <p><strong style="margin-left: 1mm;">الرقم الوطني:</strong>{{ $card->national_id }}</p>
        <p><strong style="margin-left: 1mm;">رقم الحساب:</strong>{{ $card->account_number }}</p>
        <p><strong style="margin-left: 1mm;">الهاتف:</strong>{{ $card->phone }}</p>
    </div>

    <div class="divider"></div>

    <div style="text-align: center; margin-top: 1.5mm;">
        <p>الموضف المدخل : </p>
        <div>
            {{auth()->user()->name}}
        </div>
    </div>

    <script class="no-print">
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
