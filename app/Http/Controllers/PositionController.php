<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use Illuminate\Http\Request;
use App\Models\Position;
use Inertia\Inertia;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positions = Position::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('Position/Position', [
            'positions' => $positions,
            'search_item' => $request->search_item,
            'exists' => Position::exists(),
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
    public function store(PositionRequest $request)
    {
        Position::create($request->validated());
        return to_route('position.index')->with('message', 'Created Successfully!');
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
    public function update(PositionRequest $request, Position $position)
    {
        $position->update($request->validated());
        return to_route('position.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($position, Request $request)
    {
        if ($position == 'all') {
            Position::query()->delete();
        } else {
            $search_id = $position == 'param' ? $request->selected_ids : [$position];
            Position::whereIn('id', $search_id)->delete();
        }
        return to_route('position.index')->with('message', 'Deleted Successfully!');
    }
}
