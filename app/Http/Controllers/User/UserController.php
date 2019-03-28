<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Traits\showOne;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuario = User::all();
       // return $usuario;

         return $this->showAll($usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'name'=>'required',
              'email'=>'required|email|unique:users',
                'password'=>'required|min:6|confirmed'

        ];

$this->validate($request,$reglas);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
         $campos['verification_token'] = User::generarVerificationToken();
          $campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        // return response()->json(['data' => $usuario],201);

          return $this->showOne($usuario,201);
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $usuario = User::findOrFail($id);
           // return response()->json(['data' => $usuario],200);
            return $this->showOne($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $reglas = [
           
              'email'=>'email|unique:users,email,'.$user->id,
                'password'=>'min:6|confirmed',
                    'admin'=>'in:'. User::USUARIO_ADMINISTRADOR.','.User::USUARIO_REGULAR,

        ];
            $this->validate($request,$reglas);
            if ($request->has('name')) {
                # code...
                $user->name = $request->name;
            }

             if ($request->has('email') && $user->email != $request->email) {
                # code...
                    $user->verified = User::USUARIO_NO_VERIFICADO;
                    $user->verification_token =User::generarVerificationToken();        
                    $user->email = $request ->email;
            }


             if ($request->has('password')) {
                # code...
                    $user->password = bcrypt($request->password);
            }

            if ($request->has('admin')) {
               if (!$user->esVerificado()) {

                return $this->errorResponse('Unicamente los usuario
                    verificados pueden cambiar su valor de administrador',409);
              //  return response()->json(['error'=>'Unicamente los usuarioverificados pueden cambiar su valor de administrador','code'=>409],409);
  
               }
               $user->admin = $request->admin;
            }

            if (!$user->isDirty()) {
                 return $this->errorResponse('se debe especificar almenos un valor diferente para actualizar',422);
                //return response()->json(['error'=>'se debe especificar almenos un valor diferente para actualizar','code'=>422],422);
            }
            $user->save();
            //return response()->json(['data'=>$user],200);

             return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $user = User::findOrFail($id);
          $user->delete();
         // return response()->json(['data'=>$user],200); 

                return $this->showOne($user);
    }
}
