<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{
    /**
    * funcion para mostrar todos los usuarios
    */
    function index(Request $request){

        if($request->isJson()){
            $users = User::all();
            return response()->json([$users], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /*
    * funcion para crear usuarios
    */
    function createUser(Request $request){

        if($request->isJson()){
            $data = $request->json()->all();

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'token' => str_random(32)
            ]);
            return response()->json($user, 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /*
    * funcion para modificar un usuarios en especifico
    */
    function updateUser(Request $request, $id)
    {
        if ($request->isJson()) {
            try {
                $user = User::findOrFail($id);
                $data = $request->json()->all();
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->save();
                return response()->json($user, 204);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    /*
    * funcion para eliminar un usuario en especifico
    */
    function deleteUser(Request $request, $id)
    {
        if ($request->isJson()) {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    /*
    * funcion para el login de un usuario
    */
    function getToken(Request $request){
        if($request->isJson()){
            try{
                $data = $request->json()->all();

                $user = User::where('email', $data['email'])->first();
                if($user && Hash::check($data['password'], $user->password)){
                    return response()->json($user, 200);
                }else{
                    return response()->json(['error' => 'Error in user or password'], 401);
                }
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Error in user or password'], 401);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
