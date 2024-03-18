<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payment_methods = PaymentMethod::when($request->search_item, function($q, $v){
            return $q->where('name', 'LIKE', '%'. $v .'%');
        })->paginate(10);
        return Inertia::render('PaymentMethod/PaymentMethod', [
            'payment_methods' => $payment_methods,
            'search_item' => $request->search_item,
            'exists' => PaymentMethod::exists(),

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
    public function store(PaymentMethodRequest $request)
    {
        PaymentMethod::create($request->validated());
        return to_route('payment_method.index')->with('message', 'Created Successfully!');
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
    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        $payment_method->update($request->validated());
        return to_route('payment_method.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($payment_method, Request $request)
    {
        if ($payment_method == 'all') {
            PaymentMethod::query()->delete();
        } else {
            $search_id = $payment_method == 'param' ? $request->selected_ids : [$payment_method];
            PaymentMethod::whereIn('id', $search_id)->delete();
        }
        return to_route('payment_method.index')->with('message', 'Deleted Successfully!');
    }
}
