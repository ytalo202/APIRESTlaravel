<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         //
        $vendedores = Seller::has('products')->get();
       // return response()->json(['data'=>$vendedores],200);

               return $this->showAll($vendedores);
    }

  
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $vendedores = Seller::has('products')->findOrFail($id);
        
        //return response()->json(['data'=>$vendedores],200);
     return $this->showOne($vendedores);
        //
    }

  
}
