<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceTypeRequest;
use App\Models\InvoiceType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice_types = InvoiceType::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('InvoiceType/InvoiceType', [
            'invoice_types' => $invoice_types,
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
    public function store(InvoiceTypeRequest $request)
    {
        InvoiceType::create($request->validated());
        return to_route('invoice_type.index')->with('message', 'Created Successfully!');
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
    public function update(InvoiceTypeRequest $request, InvoiceType $invoice_type)
    {
        $invoice_type->update($request->validated());
        return to_route('invoice_type.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoice_type, Request $request)
    {
        if ($invoice_type == 'all') {
            InvoiceType::query()->delete();
        } else {
            $search_id = $invoice_type == 'param' ? $request->selected_ids : [$invoice_type];
            InvoiceType::whereIn('id', $search_id)->delete();
        }
        return to_route('invoice_type.index')->with('message', 'Deleted Successfully!');
    }
}
