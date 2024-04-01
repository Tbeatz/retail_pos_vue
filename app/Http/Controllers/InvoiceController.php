<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoices = Invoice::when(auth()->user()->business_id, fn($query, $value) => $query->where('business_id', $value))
                            ->when($request->start_date, fn($query, $value) => $query->where('created_at', '>=', $value))
                            ->when($request->end_date, fn($query, $value) => $query->where('created_at', '<=', $value))
                            ->with(['transaction', 'transaction.payment_method', 'business.currency_type'])->paginate(10);
        return Inertia::render("Invoice/Invoice", [
            'invoices' => $invoices,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'exists' => auth()->user()->role_id == 2 ? Invoice::exists() : Invoice::where('business_id', auth()->user()->business_id)->exists(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = $invoice->load(['business.tax_type', 'transaction.sales.product', 'business.currency_type']);
        return Inertia::render('Invoice/InvoiceShow', [
            'invoice' => $invoice,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
