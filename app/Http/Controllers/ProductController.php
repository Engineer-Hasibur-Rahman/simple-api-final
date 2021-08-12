<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
   public function index(){
        $product=Product::all();
        return $product;
    }

    public function store(Request $request){
        $request->validate([
            "product_name"=>'required',
            'product_brand'=>'required',
            'quantity'=>'required',
        ]);
        $create=Product::create($request->all());
        if($create){
            return 'successfully add product';
        }else{
            return 'something went wrong';
        }

    }

    public function show($id){
        return Product::find($id);
    }

    public function update(Request $request, $id){
        $request->validate([
            "product_name"=>'required',
            'product_brand'=>'required',
            'quantity'=>'required',
        ]);
        $update=Product::where('id',$id)->update([
            'product_name'=>$request->product_name,
                'product_brand'=>$request->product_brand,
                'product_img'=>$request->product_img,
                'quantity'=>$request->quantity,
                "updated_at"=>Carbon::now()->toDateTimeString(),
        ]);
        if($update){
            return 'successfully Update product';
        }else{
            return 'something went wrong';
        }
    }

    public function delete($id){
        $delete= Product::destroy($id);
        if($delete){
            return 'Successfully Delete Product '.$id;
        }else{
            return 'something went wrong';
        }
    }
}
