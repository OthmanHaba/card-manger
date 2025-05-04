<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\View\View;

class PrintInvoiceController extends Controller
{
    public function printFull(Card $card): View
    {
        return view('invoices.full', compact('card'));
    }

    public function printSmall(Card $card): View
    {
        return view('invoices.small', compact('card'));
    }
}
