<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxTypeRequest;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tax_types = TaxType::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('TaxType/TaxType', [
            'tax_types' => $tax_types,
            'search_item' => $request->search_item,
            'exists' => TaxType::exists(),
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
    public function store(TaxTypeRequest $request)
    {
        TaxType::create($request->validated());
        return to_route('tax_type.index')->with('message', 'Created Successfully!');
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
    public function update(TaxTypeRequest $request, TaxType $tax_type)
    {
        $tax_type->update($request->validated());
        return to_route('tax_type.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tax_type, Request $request)
    {
        if ($tax_type == 'all') {
            TaxType::query()->delete();
        } else {
            $search_id = $tax_type == 'param' ? $request->selected_ids : [$tax_type];
            TaxType::whereIn('id', $search_id)->delete();
        }
        return to_route('tax_type.index')->with('message', 'Deleted Successfully!');
    }
}
