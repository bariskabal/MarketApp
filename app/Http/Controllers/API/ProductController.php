<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getAll()
    {
        $products = Product::with('categories','productImage')->get();

        if($products==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$products,"status"=>200]);
        }   
    }
    public function getPopularProductsAll()
    {
        $products = Product::where('unitsInStock','>=',30)->with('categories','productImage')->get();

        if($products==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$products,"status"=>200]);
        }   
    }
    public function getNewestsProductsAll()
    {
        $products = Product::orderBy('created_at', 'desc')->with('categories','productImage')->take(3)->get();

        if($products==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$products,"status"=>200]);
        }   
    }
    public function getById($id)
    {
        $product = Product::with('categories','productImage')->find($id);

        return response()->json($product);
    }

    public function getByCategoryId($id)
    {
        $products = Product::where('categoryId', $id)->with('categories')->get();

        if($products==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$products,"status"=>200]);
        } 
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'unitsInStock' => 'required|numeric|max:99999999999',
            'unitPrice' => 'required|numeric|max:99999999999',
            'categoryId' => 'required|max:20|exists:categories,id',
            'description' => 'required|max:65535',
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            $product = Product::create($request->all());

            return response()->json([$product->id,"status"=>200]);
        }
    }
    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($product->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'unitsInStock' => 'required|numeric|max:99999999999',
            'unitPrice' => 'required|numeric|max:99999999999',
            'categoryId' => 'required|max:20|exists:categories,id',
            'description' => 'required|max:65535',
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            $product->update($request->all());
            return response()->json([$product->id,"status"=>200]);
        }
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product==null){
            return response()->json(["message"=>"Boyle bir kayit bulunamadi.","status"=>404]);
        }
        else{
            Product::find($id)->delete();
            return response()->json(["message"=>'Kayit silindi.',"status"=>200]);
        }
    }
    public function getByFilter(Request $request){
        $validator = Validator::make($request->all(), [
            'filter' => 'required|max:255',
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            $products = Product::where('name', 'like', '%'.$request->filter.'%')->with('categories','productImage')->get();
            return $products; 
        }


        
    }
}
