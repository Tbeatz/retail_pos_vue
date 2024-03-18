<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessTypeRequest;
use App\Models\BusinessType;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;


class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $business_types = BusinessType::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        
        return Inertia::render('BusinessType/BusinessType', [
            'business_types' => $business_types,
            'search_item' => $request->search_item,
            'exists' => BusinessType::exists(),
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
    public function store(BusinessTypeRequest $request)
    {
        BusinessType::create($request->validated());
        return to_route('business_type.index')->with('message', 'Created Successfully!');
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
    public function update(BusinessTypeRequest $request, BusinessType $business_type)
    {
        $business_type->update($request->validated());
        return to_route('business_type.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($business_type, Request $request)
    {
        if ($business_type == 'all') {
            BusinessType::query()->delete();
        } else {
            $search_id = $business_type == 'param' ? $request->selected_ids : [$business_type];
            BusinessType::whereIn('id', $search_id)->delete();
        }
        return to_route('business_type.index')->with('message', 'Deleted Successfully!');
    }
}
