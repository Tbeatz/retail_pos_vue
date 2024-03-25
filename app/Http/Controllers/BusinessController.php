<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\CurrencyType;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $business_types = BusinessType::get();
        
        $businesses = Business::when($request->search_item, function($q, $v){
                        return $q->where('name', 'LIKE', '%'. $v .'%');
                    })->when($request->filter_item, function($q, $v){
                        return $q->where('business_type_id', $v);
                    })->with(['business_type', 'currency_type'])->paginate(10);

        return Inertia::render('Business/Business', [
            'businesses' => $businesses,
            'business_types' => $business_types,
            'filter_item' => $request->filter_item ?? '',
            'search_item' => $request->search_item,
            'currency_types' => CurrencyType::all(),
            'tax_types' => TaxType::all(),
            'exists' => Business::exists(),
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
    public function store(BusinessRequest $request)
    {
        Business::create($request->validated());
        return to_route('business.index')->with('message', 'Created Successfully!');
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
    public function update(BusinessRequest $request, Business $business)
    {
        $business->update($request->validated());
        return to_route('business.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($business, Request $request)
    {
        if ($business == 'all') {
            Business::query()->delete();
        } else {
            $search_id = $business == 'param' ? $request->selected_ids : [$business];
            Business::whereIn('id', $search_id)->delete();
        }
        return to_route('business.index')->with('message', 'Deleted Successfully!');
    }
}
