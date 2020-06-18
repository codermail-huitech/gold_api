<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::select('products.id','product_name','products.model_number','products.product_category_id','products.price_code_id','price_codes.price_code_name','product_categories.category_name','rates.price','rates.p_loss')
            ->join('price_codes', 'price_codes.id', '=', 'products.price_code_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->join('rates', 'products.price_code_id', '=', 'rates.price_code_id')
            ->get();
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

        $product->setAttribute('category_name', $product->category->category_name);
        $product->setAttribute('price_code_name', $product->priceCode->price_code_name);

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


    public function deleteProduct(Request $request,$id)
    {
        $product = Product::find($id);
        $result=$product->delete();
        return response()->json(['success'=>$result,'id'=>$id], 200);



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
