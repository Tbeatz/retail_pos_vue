<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Business;
use App\Models\Category;
use App\Models\CurrencyType;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $businesses = Business::get();
        $units = Unit::get();
        $categories = Category::get();
        
        $products = Product::when($request->search_item, function($q, $v){
                            return $q->where('name', 'LIKE', '%'. $v .'%');
                        })->when($request->filter_business, function($q, $v){
                            return $q->where('business_id', $v);
                        })->when($request->filter_category, function($q, $v){
                            return $q->where('category_id', $v);
                        })->with(['category', 'unit', 'business.currency_type', 'user'])
                        ->paginate(10);

        return Inertia::render('Product/Product', [
            'products' => $products,
            'businesses' => $businesses,
            'units' => $units,
            'categories' => $categories,
            'search_item' => $request->search_item,
            'filter_category' => $request->filter_category ?? '',
            'filter_business' => $request->filter_business ?? '',
            'exists' => Product::exists(),
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
    public function store(ProductRequest $request)
    {
        $path = $request->image ? Storage::disk('upload')->put('product_images', $request->image) : null;
        $validatedData = $request->validated();
        $validatedData['image'] = $path;
        $validatedData['user_id'] = auth()->user()->id;
        Product::create($validatedData);
        return to_route('product.index')->with('message', 'Created Successfully!');
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
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->image) {
            if ($request->image != $product->image) {
                $path = Storage::disk('upload')->put('product_images', $request->image);
                $old = $product->image;
                if ($old) {
                    Storage::disk('upload')->delete($old);
                }
            } else {
                $path = $request->image;
            }
        } else {
            $path = $product->image;
        }
        $validatedData = $request->validated();
        $validatedData['image'] = $path;
        $validatedData['user_id'] = auth()->user()->id;
        $product->update($validatedData);
        return to_route('product.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product, Request $request)
    {
        if ($product == 'all') {
            Product::query()->each(function ($product) {
                if ($product->image) {
                    Storage::disk('upload')->delete($product->image);
                }
                $product->delete();
            });
        } else {
            $search_id = $product == 'param' ? $request->selected_ids : [$product];
            $products = Product::whereIn('id', $search_id)->get();
            foreach ($products as $product) {
                if ($product->image) {
                    Storage::disk('upload')->delete($product->image);
                }
                $product->delete();
            }
        }
        return to_route('product.index')->with('message', 'Deleted Successfully!');
    }
}
