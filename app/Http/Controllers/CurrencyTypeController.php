<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyTypeRequest;
use App\Models\CurrencyType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurrencyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currency_types = CurrencyType::get();
        return Inertia::render('CurrencyType/CurrencyType', [
            'currency_types' => $currency_types,
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
    public function store(CurrencyTypeRequest $request)
    {
        CurrencyType::create($request->validated());
        return to_route('currency_type.index')->with('message', 'Created Successfully!');
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
    public function update(CurrencyTypeRequest $request, CurrencyType $currency_type)
    {
        $currency_type->update($request->validated());
        return to_route('currency_type.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrencyType $currency_type)
    {
        $currency_type->delete();
        return to_route('currency_type.index')->with('message', 'Deleted Successfully!');
    }
}
