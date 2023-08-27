<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

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
        $user = User::all();
        return $this->successResponse($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = $this->validateUser();
        if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => \Illuminate\Support\Facades\Hash::make($request->get('password')),
        ]);

        return $this->successResponse($user,'User Created', 201);
       
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
        $user = User::find($id);
        if($user){
            return $this->successResponse($user);
         }
         return $this->errorResponse('The user is not found' , 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = \Illuminate\Support\Facades\Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        \Illuminate\Support\Facades\DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));

        return $this->successResponse(new UserResource($user) , 'User Updated', 201);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      $user = User::find($id);
        if($user){
            $user->delete();
            return $this->successResponse(null, 'User Deleted',200);  
        } 
        return $this->errorResponse('The user is not found' , 404);
    }
}
