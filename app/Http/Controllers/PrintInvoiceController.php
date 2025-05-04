<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\View\View;

class PrintInvoiceController extends Controller
{
    public function printFull(Card $card): View
    {
        // You might want to eager load relationships if needed for the invoice
        // $card->load('someRelation');

        return view('invoices.full', compact('card'));
    }

    public function printSmall(Card $card): View
    {
        // You might want to eager load relationships if needed for the invoice
        // $card->load('someRelation');

        return view('invoices.small', compact('card'));
    }
}
