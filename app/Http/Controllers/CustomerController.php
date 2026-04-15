<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\item;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = customer::withSum('item', 'total')->with('item')->get();

        $items = item::get();

        $customer = customer::orderBy('id', 'desc')->get();

        return view('pages.orders.order', compact('customer', 'items', 'orders'));
    }
    public function show(Request $request)
    {
        //
        $itemDetail = item::get();
        $items = customer::where('id', $request->id)->with('item')->first();
        return view('pages.orders.orderEdit', compact('items', 'itemDetail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function validateField(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'qty' => 'required|min:1',
            'amount' => 'required|min:1',
            'total' => 'required|min:1',
            'phone' =>  ['required', 'regex:/^\+?[0-9]+( [0-9]+)*$/'],
        ];

        $field = $request->field;

        if (!isset($rules[$field])) {
            return response()->json(['success' => true]);
        }

        $validator = Validator::make(
            [$field => $request->value],
            [$field => $rules[$field]]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first($field)
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        //

        $customer = customer::create([
            "name" => $request->customer_name,
            "date" => $request->date,
            "phone" => $request->phone,

        ]);
        $items = json_decode($request->items);

        foreach ($items as $item) {
            $order = order::create([

                'name' => $item->name,
                'qty' =>  $item->qty,
                'amount' =>  $item->amount,
                'total' =>  $item->total,
                'c_id' =>  $customer->id,
            ]);
        }


        return back()->with('msg', 'Customer Added Successfully!');
    }
    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // $items = customer::where('id', $request->id)->with('item')->first();


        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customer $customer)
    {

        return $request->all();

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        customer::where('id', $request->id)->delete();
        order::where('c_id', $request->id)->delete();

        return back()->with('msg', 'Customer Deleted Successfully!');
    }
}
