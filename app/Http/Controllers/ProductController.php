<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::select()->get();
        return response()->json(['success'=>1,'data'=>$products], 200,[],JSON_NUMERIC_CHECK);
    }
    public function saveProduct(Request $request)
    {
        $product=new Product();
        $product->model_number =$request->input('model_number');
        $product->product_name =$request->input('product_name');
        $product->product_category_id =$request->input('product_category_id');
        $product->price_code_id =$request->input('price_code_id');
        $product->save();
        return response()->json(['success'=>1,'data'=>$product], 200);
    }

    public function destroy(Product $product)
    {
        //
    }
}
