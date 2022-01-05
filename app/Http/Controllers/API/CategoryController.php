<?php

namespace App\Http\Controllers\API;


use App\Product;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct(Request $request){ 
        return $request->token;
    }

    public function getAll()
    {
        $categories = Category::get();

        if($categories==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$categories,"status"=>200]);
        }   
    }
    public function getPopularCategories()
    {
        $categories = Category::withCount('Product')->take(3)->get();;

        if($categories==null){
            return response()->json(["message"=>"Kayit Bulunamadı.","status"=>404]);
        }
        else{
            return response()->json([$categories,"status"=>200]);
        }   
    }
    public function getById($id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            $category = Category::create($request->all());

            return response()->json([$category->id,"status"=>200]);
        }
    }
    public function update(Request $request, Category $category)
    {
        $cat = Category::findOrFail($category->id);
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            
            $cat->update($request->all());
            return response()->json([$category->id,"status"=>200]);
        }
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category==null){
            return response()->json(["message"=>"Boyle bir kayit bulunamadi.","status"=>404]);
        }
        else{
            Category::find($id)->delete();
            return response()->json(["message"=>'Kayit silindi.',"status"=>200]);
        }
    }
    public function getByFilter(Request $request){
        $validator = Validator::make($request->all(), [
            'search_query' => 'required|max:255',
        ]);

        if($validator->fails()) {
            return response()->json([$validator->errors(),"status"=>404]);
        }
        else if($validator->validated()) {
            $categories = Category::where('categoryName', 'like', '%'.$request->search_query.'%')->get();
            if($categories==null){
                return response()->json(["message"=>"Boyle bir kayit bulunamadi.","status"=>404]);
            }
            else{
                return response()->json([$categories,"status"=>200]);
            }
             
        }
  
    }
}
