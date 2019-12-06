<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use ApiResponser;

    /**
    * funcion para mostrar todos los usuarios
    */
    function index(Request $request){
        $users = User::all();

		return $this->successResponse($users);
    }

    /*
    * funcion para crear usuarios
    */
    function store(Request $request){
        $rules = [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
		];

        $this->validate($request, $rules);
        
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);
        $fields['token'] = str_random(32);

		$user = User::create($fields);

		return $this->successResponse($user, Response::HTTP_CREATED);
        
    }

    /**
	 * return an specific user
	 *
	 * @return Illuminate\Http\Response
	 */
	public function show($id) {
		$user = User::findOrFail($id);

		return $this->successResponse($user);
	}

    /*
    * funcion para modificar un usuarios en especifico
    */
    function update(Request $request, $id)
    {
        $rules = [
			'first_name' => 'max:255',
			'last_name' => 'max:255',
			'email' => 'email|unique:users,email' . $id,
			'password' => 'min:6|confirmed',
		];

        $this->validate($request, $rules);

        $user = User::findOrFail($id);

        $user = fill($request->all());

        if($request->has('password')){
            $user->password = Hash::make($request->passwrod);
        }

		if ($user->isClean()) {
			return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$user->save();

		return $this->successResponse($user);
    }

    /*
    * funcion para eliminar un usuario en especifico
    */
    function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

		$user->delete();

		return $this->successResponse($user);
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
