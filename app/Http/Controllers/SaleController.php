<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DiscountType;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\TaxType;
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
                    })->where('business_id', auth()->user()->business_id)->with(['category', 'business.currency_type'])->get();

        $categories = Category::get();
        return Inertia::render('Sale/Sale', [
            'products' => $products,
            'categories' => $categories,
            'search_item' => $request->search_item,
            'filter_item' => $request->filter_item,
            'currency_type' => auth()->user()->business ? auth()->user()->business->currency_type->name : '',
            'tax_rate' => auth()->user()->business ? auth()->user()->business->tax_type->tax_rate : '',
            'payment_methods' => PaymentMethod::all(),
            'exists' => auth()->user()->role_id == 2 ? Product::exists() : Product::where('business_id', auth()->user()->business_id)->exists(),
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
        $transaction = Transaction::create();
        foreach ($request->data as $data) {
            Sale::create([
                'transaction_id' => $transaction->id,
                'product_id' => $data['id'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'total_price' => $data['total_price'],
            ]);
        }
        return to_route('sale.index')->with('transaction_id', $transaction->id);
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
