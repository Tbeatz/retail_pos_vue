<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['business_id'] = auth()->user()->business->id;
        $transaction->update($validatedData);
        Invoice::create([
            'transaction_id' => $transaction->id,
            'invoice_status_id' => 2, //paid
            'invoice_type_id' => 1, //customer
            'business_id' => auth()->user()->business->id,
        ]);
        return to_route('sale.index')->with('message', 'Transaction Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
