<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $path = $request->file('image')->storePublicly('/public');
    
                $product->image = Storage::url($path);
            }
        }

        $product->save();

        return response()->json(['message' => 'Product created successfully.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::where('id', $id)->get();
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => "Product not found!"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            
            $product_prop = ['name', 'description', 'price', 'image'];

            foreach ($product_prop as $prop) {
                // if ($prop === 'image') {
                //     // $this->validate($request, [
                //     //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                //     // ]);
                //     if ($request->file('image')->isValid()) {
                //         $path = $request->file('image')->storePublicly('/public');
            
                //         $product->image = Storage::url($path);
                //     }
                // }
                 if ($request->has($prop)) {
                    $product->{$prop} = $request->{$prop};
                } else {
                    $product->{$prop} = $product->{$prop};
                }
            }

            $product->save();
            return response()->json(['message' => 'Product updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
