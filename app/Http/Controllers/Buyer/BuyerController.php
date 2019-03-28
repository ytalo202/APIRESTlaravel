<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compradores = Buyer::has('transactions')->get();
        //return response()->json(['data'=>$compradores],200);
        return $this->showAll($compradores);
    }

   
    public function show($id)
    {

        $compradores = Buyer::has('transactions')->findOrFail($id);

        //return response()->json(['data'=>$compradores],200);

            return $this->showOne($compradores);

        //
    }

 
    
}
