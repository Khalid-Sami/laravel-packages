<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 10/20/2019
 * Time: 02:48 ص
 */

namespace App\Http\Controllers\Stripe;


use Illuminate\Http\Request;

class InvoiceController
{

    public function invoices()
    {
        $invoices = auth()->user()->invoices();


        return view('invoice', compact('invoices'));
    }

    public function invoice(Request $request, $invoice_id)
    {
        return $request->user()->downloadInvoice($invoice_id, [
            'vendor' => 'Your Company',
            'product' => 'Your Product',
        ]);
    }

}
