<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class productController extends Controller
{
    public $trueval = true;
    public function index()
    {
        $Product = Product::get();
        $data['status'] = $this->trueval;
        $data['message'] = "Product List Found Successfully";
        $data['data'] = $Product;
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = new Product();

        $product->product_name = $validated['product_name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->description = $validated['description'] ?? null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath ?? null;
        }
        $product->save();
        $data['status'] = $this->trueval;
        $data['message'] = " Product Created Successfully";
        $data['data'] = $product;
        return response()->json($data, 200);
        // return response()->json($product, 201);
    }


    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $validated = $request->validate([
            'product_name' => 'sometimes|required|string|max:255', 
            'stock' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $product->product_name = $validated['product_name'] ?? $product->product_name;
        $product->price = $validated['price'] ?? $product->price;
        $product->stock = $validated['stock'] ?? $product->stock;
        $product->description = $validated['description'] ?? $product->description;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->save();
        $data['status'] = $this->trueval;
        $data['message'] = " Product Updated Successfully.";
        $data['data'] = $product;
        return response()->json($data, 200);
    }


    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
         $data['status'] = $this->trueval;
        $data['message'] = " Product Deleted Successfully.";
        $data['data'] = null;
        return response()->json($data, 200);
    }
}
