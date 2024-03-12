<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountTypeRequest;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiscountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $discount_types = DiscountType::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('DiscountType/DiscountType', [
            'discount_types' => $discount_types,
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
    public function store(DiscountTypeRequest $request)
    {
        DiscountType::create($request->validated());
        return to_route('discount_type.index')->with('message', 'Created Successfully!');
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
    public function update(DiscountTypeRequest $request, DiscountType $discount_type)
    {
        $discount_type->update($request->validated());
        return to_route('discount_type.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($discount_type, Request $request)
    {
        if ($discount_type == 'all') {
            DiscountType::query()->delete();
        } else {
            $search_id = $discount_type == 'param' ? $request->selected_ids : [$discount_type];
            DiscountType::whereIn('id', $search_id)->delete();
        }
        return to_route('discount_type.index')->with('message', 'Deleted Successfully!');
    }
}
