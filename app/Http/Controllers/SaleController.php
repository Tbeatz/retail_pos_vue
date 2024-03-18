<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::when($request->search_item, function($q, $v){
                        return $q->where('name', 'LIKE', '%'. $v .'%');
                    })->when($request->filter_item, function($q, $v){
                        return $q->where('category_id', $v);
                    })->with(['currency_type', 'category'])->get();

        $categories = Category::get();
        return Inertia::render('Sale/Sale', [
            'products'=> $products,
            'categories' => $categories,
            'search_item' => $request->search_item,
            'filter_item' => $request->filter_item,
        ]);
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
        return to_route('sale.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
