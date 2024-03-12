<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use Illuminate\Http\Request;
use App\Models\Unit;
use Inertia\Inertia;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Unit::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('Unit/Unit', [
            'units' => $units,
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
    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return to_route('unit.index')->with('message', 'Created Successfully!');
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
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return to_route('unit.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($unit, Request $request)
    {
        if ($unit == 'all') {
            Unit::query()->delete();
        } else {
            $search_id = $unit == 'param' ? $request->selected_ids : [$unit];
            Unit::whereIn('id', $search_id)->delete();
        }
        return to_route('unit.index')->with('message', 'Deleted Successfully!');
    }
}
