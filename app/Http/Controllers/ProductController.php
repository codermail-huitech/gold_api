<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::select('id','product_name','model_number','product_category_id','price_code_id')->get();
        return response()->json(['success'=>1,'data'=>$products], 200,[],JSON_NUMERIC_CHECK);
    }


    public function saveProduct(Request $request)
    {
//        return response()->json(['success'=>1,'data'=>$request->input('model_number')], 200,[],JSON_NUMERIC_CHECK);
        $product=new Product();
        $product->model_number=$request->input('model_number');
        $product->product_name=$request->input('product_name');
        $product->price_code_id=$request->input('price_code_id');
        $product->product_category_id=$request->input('product_category_id');
        $product->save();
        return response()->json(['success'=>1,'data'=>$product], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateProduct(Request $request)
    {
        $product=new Product();
        $product=Product::find($request->input('id'));
        $product->model_number=$request->input('model_number');
        $product->product_name=$request->input('product_name');
        $product->price_code_id=$request->input('price_code_id');
        $product->product_category_id=$request->input('product_category_id');
        $product->update();
        return response()->json(['success'=>1,'data'=>$product], 200,[],JSON_NUMERIC_CHECK);
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
