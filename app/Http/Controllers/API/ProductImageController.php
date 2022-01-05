<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'image' => 'required|mimes:doc,docx,pdf,txt,csv,jpg|max:2048',
            'product_id' => 'required'
      ]);   
      if($validator->fails()) {          
          
          return response()->json(['error'=>$validator->errors()], 401);                        
       }  
      if ($file = $request->file('image')) {
        $path = Storage::putFile('/public/productImages', $request->file('image'));
          $prod_id = $request->product_id;
        
          $link = Storage::url($path);
          //store your file into directory and db
          $save = new ProductImage();
          $save->product_id = $prod_id;
          $save->image= $path;
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
        $productImage = ProductImage::where("product_id",$id)->first()->image;
        return response()->json(env("APP_URL").$productImage);
    }

}
