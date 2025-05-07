<?php

namespace App\Http\Controllers\Api;
use App\Helpers;
use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')->when($request->status, function ($query, $status){
            return $query->where('status', $status);
        })->get();
        return ResponseHelpers::jsonResponse(data: $products, status: 'sukses', code:200);
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
        $request->validate([
            'category_id'   => 'required|exists:categories,id',           //maksud exist adlah wajib ada di table tersebut
            'name'          => 'required',
            'price'         => 'required',
            'criteria'      => 'required',
        ]);

        //yang ada nullable di table productnya maka itu aman tidak perlu diisi tapi yang tidak ada itu wajib dicantumkan
        $product                = new Product;
        $product->category_id   = $request->category_id;
        $product->name          = $request->name;
        $product->price         = $request->price;
        $product->criteria      = $request->criteria;
        $product->stock         = 0;

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/products'.$image->hashName());
            $product->image = $image->hashName();
        }

        $product->save();

        $product = Product::with('category')->find($product->id);

        return ResponseHelpers::jsonResponse(data: $product, status: 'sukses', code: 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        if(!$product){
            return ResponseHelpers::jsonResponse(status: '404: error', message: 'Product not found', code: 404);
        }
        return ResponseHelpers::jsonResponse(data: $product, status: 'sukses', code: 200);
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
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ResponseHelpers::jsonResponse(status: '404: error', message: 'Product not found', code: 404);
        }

        $product->category_id   = $request->category_id;
        $product->name          = $request->name;
        $product->price         = $request->price;
        $product->criteria      = $request->criteria;
        $product->favorite      = $request->favorite;
        $product->status        = $request->status;
        $product->stock         = $request->stock;

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/products'.$image->hashName());
            $product->image = $image->hashName();
        }

        // $product->update($request->all());

        return ResponseHelpers::jsonResponse(status: 'sukses', message: 'Product updated',data: $product , code: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return ResponseHelpers::jsonResponse(status: '404: error', message: 'Product not found', code: 404);
        }
        $product->delete();
        return ResponseHelpers::jsonResponse(data: $product, status: 'sukses', message: 'berhasil terhapus');
    }
}
