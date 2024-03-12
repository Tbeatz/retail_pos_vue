<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStatusRequest;
use App\Models\InvoiceStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice_statuses = InvoiceStatus::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('InvoiceStatus/InvoiceStatus', [
            'invoice_statuses' => $invoice_statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //No need becz i did with modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceStatusRequest $request)
    {
        InvoiceStatus::create($request->validated());
        return to_route('invoice_status.index')->with('message', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceStatusRequest $request, InvoiceStatus $invoice_status)
    {
        $invoice_status->update($request->validated());
        return to_route('invoice_status.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoice_status, Request $request)
    {
        if ($invoice_status == 'all') {
            InvoiceStatus::query()->delete();
        } else {
            $search_id = $invoice_status == 'param' ? $request->selected_ids : [$invoice_status];
            InvoiceStatus::whereIn('id', $search_id)->delete();
        }
        return to_route('invoice_status.index')->with('message', 'Deleted Successfully!');
    }
}
