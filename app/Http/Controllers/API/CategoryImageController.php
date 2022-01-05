<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\CategoryImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'image' => 'required|mimes:doc,docx,pdf,txt,csv,jpg|max:2048',
            'category_id' => 'required'
      ]);   

      if($validator->fails()) {          
          
          return response()->json(['error'=>$validator->errors()], 401);                        
       }  


      if ($file = $request->file('image')) {
          $path = Storage::putFile('/public/categoryImages', $request->file('image'));
          $categ_id = $request->category_id;
        
          $link = Storage::url($path);
          //store your file into directory and db
          $save = new CategoryImage();
          $save->category_id = $categ_id;
          $save->image= $link;
          $save->save();
          
          return response()->json([
              "success" => true,
              "message" => "File successfully uploaded",
              "file" => $link
          ]);

      }
    }
    public function getById($id)
    {
        $categoryImage = CategoryImage::where("category_id",$id)->first();
        return response()->json($categoryImage);
    }
}
